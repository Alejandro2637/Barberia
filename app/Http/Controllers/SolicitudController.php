<?php

namespace App\Http\Controllers;

use App\Enums\EstadoCitas;
use App\Http\Requests\CitaRequest;
use App\Mail\CitaConfirmada;
use App\Models\Citas;
use App\Models\Servicio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SolicitudController extends Controller
{
    public function store(CitaRequest $request)
    {
        $servicioId = Servicio::desdeTexto($request->service)?->id;

        if (! $servicioId) {
            return back()
                ->withInput()
                ->withErrors(['service' => 'Elige un servicio válido.']);
        }

        try {
            $citas = DB::transaction(function () use ($request, $servicioId) {
                $ocupado = Citas::whereFechaCita($request->fecha_cita)
                    ->whereHoraCita($request->hora_cita)
                    ->where('estado', '!=', EstadoCitas::Cancelado->value)
                    ->lockForUpdate()
                    ->exists();

                if ($ocupado) {
                    return null;
                }

                $citas = new Citas();
                $citas->name_cliente = $request->name;
                $citas->email_cliente = $request->email;
                $citas->phone_cliente = $request->phone;
                $citas->fecha_cita = $request->fecha_cita;
                $citas->hora_cita = $request->hora_cita;
                $citas->servicio_id = $servicioId;
                // 'cancelacion' no está en $fillable: asignación directa.
                $citas->cancelacion = Str::random(64);
                $citas->save();

                return $citas;
            });
        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->withErrors(['hora_cita' => 'Ese turno ya fue reservado. Elige otra hora.']);
        }

        if (! $citas) {
            return back()
                ->withInput()
                ->withErrors(['hora_cita' => 'Ese turno ya fue reservado. Elige otra hora.']);
        }

        try {
            Mail::to($citas->email_cliente)->send(new CitaConfirmada(
                $citas->load('servicio'),
                route('citas.cancelar.enlace', ['token' => $citas->cancelacion]),
            ));
        } catch (\Throwable $e) {
            // No romper la reserva si el correo falla.
        }

        return back()->with('succes', 'cita registrada, revisa tu correo');
    }

    public function completar(Citas $cita)
    {
        // Defensa en profundidad: la ruta ya exige 'barber',
        // pero el método no confía solo en la ruta (IDOR).
        abort_unless(auth()->user()?->isBarber(), 403);
        $cita->completar();
        Log::info('Barbero completó cita', ['user_id' => auth()->id(), 'cita_id' => $cita->id]);

        return back()->with('succes', 'cita completada');
    }

    public function cancelar(Citas $cita, Request $request)
    {
        abort_unless(auth()->user()?->isBarber(), 403);

        $data = $request->validate([
            'motivo' => 'nullable|string|max:255',
        ]);

        $cita->cancelar($data['motivo'] ?? null);
        Log::info('Barbero canceló cita', ['user_id' => auth()->id(), 'cita_id' => $cita->id]);

        return back()->with('succes', 'cita cancelada');
    }
}
