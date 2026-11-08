<?php

namespace App\Http\Controllers;

use App\Enums\EstadoCitas;
use App\Mail\CitaConfirmada;
use App\Models\Citas;
use App\Models\horario_barberias;
use App\Models\Servicio;
use App\Models\vacacioness;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservaController extends Controller
{
    /**
     * Wizard de reserva en 3 pasos (un solo barbero):
     * 1. servicio → 2. fecha/hora → 3. datos y confirmación.
     */
    public function index()
    {
        $servicios = Servicio::orderBy('nombre')->get();

        return view('reservar', compact('servicios'));
    }

    /**
     * GET /disponibilidad?fecha=YYYY-MM-DD[&token=...]
     * Turnos generados desde horario_barberia.duracion (default 15),
     * menos citas activas y vacaciones. Sin parámetro de barbero.
     * El token opcional excluye la propia cita del ocupante (reprogramación).
     */
    public function disponibilidad(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date_format:Y-m-d',
            'token' => 'nullable|string|max:64',
        ]);

        $fecha = $request->input('fecha');
        $carbon = Carbon::parse($fecha)->startOfDay();

        // 1. Vacaciones: día cerrado.
        $vacacion = vacacioness::whereDate('fecha', $fecha)->first();
        if ($vacacion) {
            return response()->json([
                'fecha' => $fecha,
                'abierto' => false,
                'motivo' => $vacacion->razon ?? 'Día no laborable',
                'turnos' => [],
            ]);
        }

        // 2. Horario del día de la semana (0 = domingo … 6 = sábado).
        $horario = horario_barberias::where('dias_semana', $carbon->dayOfWeek)->first();

        if (! $horario || ! $horario->open || ! $horario->start_dia || ! $horario->end_dia) {
            return response()->json([
                'fecha' => $fecha,
                'abierto' => false,
                'motivo' => 'Cerrado',
                'turnos' => [],
            ]);
        }

        // 3. Generar turnos desde la duración configurada (default 15).
        if (empty($horario->duracion)) {
            $horario->duracion = 15;
        }
        $todos = $horario->generarHorario();

        // 4. Quitar horas ya ocupadas por citas activas.
        // Con token (reprogramación), la propia cita no cuenta como ocupante.
        $exceptoId = $request->filled('token')
            ? Citas::where('cancelacion', $request->input('token'))->value('id')
            : null;

        $ocupadasQuery = Citas::whereDate('fecha_cita', $fecha)
            ->where('estado', '!=', EstadoCitas::Cancelado->value);
        if ($exceptoId) {
            $ocupadasQuery->where('id', '!=', $exceptoId);
        }
        $ocupadas = $ocupadasQuery
            ->pluck('hora_cita')
            ->map(fn ($h) => Carbon::parse($h)->format('H:i'))
            ->all();

        // 5. Si es hoy, quitar horas pasadas.
        $ahora = now()->format('H:i');
        $esHoy = $carbon->isToday();

        $turnos = [];
        foreach ($todos as $hora) {
            $disponible = ! in_array($hora, $ocupadas, true)
                && (! $esHoy || $hora > $ahora);

            $turnos[] = [
                'hora' => $hora,
                'disponible' => $disponible,
            ];
        }

        return response()->json([
            'fecha' => $fecha,
            'abierto' => true,
            'motivo' => null,
            'turnos' => $turnos,
        ]);
    }

    /**
     * Enlaces personales de gestión de una cita (cancelación y reprogramación).
     */
    private function enlacesCita(Citas $cita): array
    {
        return [
            'enlaceCancelacion' => route('citas.cancelar.enlace', ['token' => $cita->cancelacion]),
            'enlaceReprogramar' => route('citas.reprogramar.enlace', ['token' => $cita->cancelacion]),
        ];
    }

    /**
     * Guarda la cita creada desde el wizard.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' => 'required|date_format:H:i',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if (! Citas::horarioDisponible($data['fecha_cita'], $data['hora_cita'])) {
            return back()
                ->withInput()
                ->withErrors(['hora_cita' => 'Ese turno ya fue reservado. Elige otra hora.']);
        }

        $cita = Citas::create([
            'name_cliente' => $data['name'],
            'email_cliente' => $data['email'],
            'phone_cliente' => $data['phone'],
            'servicio_id' => $data['servicio_id'],
            'fecha_cita' => $data['fecha_cita'],
            'hora_cita' => $data['hora_cita'],
            'cancelacion' => Str::random(64),
        ]);

        $enlaces = $this->enlacesCita($cita);

        try {
            Mail::to($cita->email_cliente)->send(new CitaConfirmada(
                $cita->load('servicio'),
                $enlaces['enlaceCancelacion'],
                $enlaces['enlaceReprogramar'],
            ));
        } catch (\Throwable $e) {
            // No romper la reserva si el correo falla; la confirmación en pantalla sigue valiendo.
        }

        return view('reserva-confirmada', [
            'cita' => $cita->load('servicio'),
        ] + $enlaces);
    }

    /**
     * Cancelación por enlace (token único enviado en la confirmación).
     * GET /cancelar-cita/{token}
     */
    public function cancelarPorEnlace(string $token)
    {
        $cita = Citas::where('cancelacion', $token)->firstOrFail();

        if ($cita->estado === EstadoCitas::Cancelado) {
            return view('reserva-cancelada', ['cita' => $cita, 'yaCancelada' => true]);
        }

        $cita->cancelar('Cancelada por el cliente desde el enlace');

        return view('reserva-cancelada', ['cita' => $cita, 'yaCancelada' => false]);
    }

    /**
     * Reprogramación por enlace (token único enviado en la confirmación).
     * GET /reprogramar-cita/{token}
     */
    public function reprogramarPorEnlace(string $token)
    {
        $cita = Citas::where('cancelacion', $token)->with('servicio')->firstOrFail();

        if ($this->puedeReprogramar($cita)) {
            return view('reserva-reprogramar', [
                'cita' => $cita,
                'token' => $token,
            ]);
        }

        return view('reserva-reprogramada', [
            'cita' => $cita,
            'noReprogramable' => true,
        ]);
    }

    /**
     * Aplica la reprogramación pedida desde el enlace.
     * POST /reprogramar-cita/{token}
     */
    public function actualizarPorEnlace(Request $request, string $token)
    {
        $cita = Citas::where('cancelacion', $token)->with('servicio')->firstOrFail();

        if (! $this->puedeReprogramar($cita)) {
            return back()->withErrors(['fecha_cita' => 'Esta cita ya no se puede reprogramar.']);
        }

        $data = $request->validate([
            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' => 'required|date_format:H:i',
        ]);

        // La propia cita no bloquea su turno actual.
        if (! Citas::horarioDisponible($data['fecha_cita'], $data['hora_cita'], $cita->id)) {
            return back()
                ->withInput()
                ->withErrors(['hora_cita' => 'Ese turno ya fue reservado. Elige otra hora.']);
        }

        $cita->update([
            'fecha_cita' => $data['fecha_cita'],
            'hora_cita' => $data['hora_cita'],
        ]);

        $enlaces = $this->enlacesCita($cita);

        try {
            Mail::to($cita->email_cliente)->send(new CitaConfirmada(
                $cita->load('servicio'),
                $enlaces['enlaceCancelacion'],
                $enlaces['enlaceReprogramar'],
            ));
        } catch (\Throwable $e) {
            // No romper la reprogramación si el correo falla; la pantalla confirma el cambio.
        }

        return view('reserva-reprogramada', [
            'cita' => $cita->load('servicio'),
            'noReprogramable' => false,
        ] + $enlaces);
    }

    /**
     * Solo una cita confirmada y futura se puede reprogramar.
     */
    private function puedeReprogramar(Citas $cita): bool
    {
        return $cita->estado === EstadoCitas::Confirmado
            && ! Carbon::parse($cita->fecha_cita)->isBefore(today());
    }
}
