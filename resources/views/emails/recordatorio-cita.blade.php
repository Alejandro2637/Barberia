<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Recordatorio de cita</title></head>
<body style="font-family: sans-serif; color: #1f2937; max-width: 560px; margin: 0 auto; padding: 24px;">
    <h2>Recordatorio: tu cita es mañana</h2>
    <p>Hola {{ $cita->name_cliente }},</p>
    <p>Te recordamos tu cita de mañana:</p>
    <ul>
        <li><strong>Servicio:</strong> {{ $cita->servicio?->nombre ?? '—' }}</li>
        <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}</li>
        <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}</li>
    </ul>
    <p>Si no podrás asistir, puedes reprogramar o cancelar con tus enlaces personales para liberar el turno:</p>
    <ul>
        @if (! empty($enlaceReprogramar))
            <li>Reprogramar: <a href="{{ $enlaceReprogramar }}">{{ $enlaceReprogramar }}</a></li>
        @endif
        <li>Cancelar: <a href="{{ $enlaceCancelacion }}">{{ $enlaceCancelacion }}</a></li>
    </ul>
    <p>¡Te esperamos!</p>
</body>
</html>
