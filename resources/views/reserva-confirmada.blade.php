<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cita confirmada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white rounded-lg shadow p-8 max-w-lg w-full mx-4 text-center">
    <h1 class="text-2xl font-bold text-green-700 mb-4">¡Cita reservada!</h1>
    <div class="text-left bg-gray-50 rounded-lg p-4 mb-6 text-sm space-y-1">
        <p><strong>Cliente:</strong> {{ $cita->name_cliente }}</p>
        <p><strong>Servicio:</strong> {{ $cita->servicio?->nombre ?? '—' }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}</p>
        <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}</p>
    </div>
    <p class="text-sm text-gray-600 mb-2">Tus enlaces personales:</p>
    <div class="space-y-2 mb-2">
        <p class="text-xs text-gray-500">Cambiar fecha u hora:</p>
        <a href="{{ $enlaceReprogramar }}" class="text-blue-600 underline break-all text-sm">{{ $enlaceReprogramar }}</a>
        <p class="text-xs text-gray-500">Cancelar la cita:</p>
        <a href="{{ $enlaceCancelacion }}" class="text-blue-600 underline break-all text-sm">{{ $enlaceCancelacion }}</a>
    </div>
    <p class="text-xs text-gray-500 mt-2">Guárdalos: es la única forma de gestionar tu cita en línea.</p>
    <div class="mt-6">
        <a href="{{ url('/') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Volver al inicio</a>
    </div>
</div>
</body>
</html>
