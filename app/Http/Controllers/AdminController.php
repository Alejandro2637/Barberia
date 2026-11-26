<?php

namespace App\Http\Controllers;

use App\Enums\EstadoCitas;
use App\Models\Citas;
use App\Models\horario_barberias;
use App\Models\Servicio;
use App\Models\DatosNegocio;
use App\Models\vacacioness;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Panel del día: citas de hoy + próximas, con acciones.
     */
    public function panel()
    {
        $hoy = today()->toDateString();

        $citasHoy = Citas::with('servicio')
            ->whereDate('fecha_cita', $hoy)
            ->orderBy('hora_cita')
            ->get();

        $proximas = Citas::with('servicio')
            ->whereDate('fecha_cita', '>', $hoy)
            ->where('estado', EstadoCitas::Confirmado->value)
            ->orderBy('fecha_cita')
            ->orderBy('hora_cita')
            ->limit(20)
            ->get();

        return view('admin.panel', compact('citasHoy', 'proximas'));
    }

    /**
     * Gestión del horario semanal (un solo barbero).
     */
    public function horarios()
    {
        $horarios = horario_barberias::orderBy('dias_semana')->get()->keyBy('dias_semana');
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        return view('admin.horarios', compact('horarios', 'dias'));
    }

    public function actualizarHorarios(Request $request)
    {
        $data = $request->validate([
            'dias' => 'required|array|size:7',
            'dias.*.open' => 'nullable',
            'dias.*.start_dia' => 'nullable|date_format:H:i',
            'dias.*.end_dia' => 'nullable|date_format:H:i',
            'dias.*.duracion' => 'nullable|integer|min:5|max:240',
        ]);

        foreach ($data['dias'] as $dia => $h) {
            horario_barberias::updateOrCreate(
                ['dias_semana' => $dia],
                [
                    'open' => ! empty($h['open']),
                    'start_dia' => $h['start_dia'] ?? null,
                    'end_dia' => $h['end_dia'] ?? null,
                    'duracion' => $h['duracion'] ?? 15,
                ]
            );
        }

        return back()->with('succes', 'Horarios actualizados');
    }

    /**
     * Precios y duración de los servicios (un solo barbero).
     */
    public function servicios()
    {
        $servicios = Servicio::orderBy('nombre')->get();

        return view('admin.servicios', compact('servicios'));
    }

    public function actualizarServicios(Request $request)
    {
        $data = $request->validate([
            'servicios' => 'required|array',
            'servicios.*.precio' => 'required|numeric|min:0',
            'servicios.*.duracion' => 'required|integer|min:5|max:240',
        ]);

        foreach ($data['servicios'] as $id => $s) {
            Servicio::where('id', $id)->update([
                'precio' => $s['precio'],
                'duracion' => $s['duracion'],
            ]);
        }

        return back()->with('succes', 'Precios actualizados');
    }

    /**
     * Datos del negocio (dirección de la portada y el mapa).
     */
    public function datos()
    {
        $datos = DatosNegocio::first();

        return view('admin.datos', compact('datos'));
    }

    public function actualizarDatos(Request $request)
    {
        $data = $request->validate([
            'direccion' => 'nullable|string|max:255',
        ]);

        DatosNegocio::updateOrCreate(
            ['id' => 1],
            ['direccion' => $data['direccion'] ?? null]
        );

        return back()->with('succes', 'Dirección actualizada');
    }

    /**
     * Bloqueo de fechas (vacaciones / días no laborables).
     */
    public function vacaciones()
    {
        $vacaciones = vacacioness::orderBy('fecha', 'desc')->get();

        return view('admin.vacaciones', compact('vacaciones'));
    }

    public function guardarVacacion(Request $request)
    {
        $data = $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'razon' => 'nullable|string|max:255',
        ]);

        vacacioness::updateOrCreate(
            ['fecha' => $data['fecha']],
            ['razon' => $data['razon'] ?? null]
        );

        return back()->with('succes', 'Fecha bloqueada');
    }

    public function eliminarVacacion(vacacioness $vacacion)
    {
        $vacacion->delete();

        return back()->with('succes', 'Bloqueo eliminado');
    }
}
