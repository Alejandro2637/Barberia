<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Cita confirmada</title></head>
<body style="font-family: sans-serif; color: #1f2937; max-width: 560px; margin: 0 auto; padding: 24px;">
    <h2 style="color: #15803d;">¡Tu cita está confirmada!</h2>
    <p>Hola {{ $cita->name_cliente }},</p>
    <p>Estos son los datos de tu cita:</p>
    <ul>
        <li><strong>Servicio:</strong> {{ $cita->servicio?->nombre ?? '—' }}</li>
        <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}</li>
        <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}</li>
    </ul>
    <p>Tus enlaces personales para gestionar la cita:</p>
    <ul>
        @if (! empty($enlaceReprogramar))
            <li>Reprogramar: <a href="{{ $enlaceReprogramar }}">{{ $enlaceReprogramar }}</a></li>
        @endif
        <li>Cancelar: <a href="{{ $enlaceCancelacion }}">{{ $enlaceCancelacion }}</a></li>
    </ul>
    <p style="color: #6b7280; font-size: 12px;">Guárdalos: es la única forma de gestionar tu cita en línea.</p>
</body>
</html>
