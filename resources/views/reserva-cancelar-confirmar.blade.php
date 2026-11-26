<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar cita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white rounded-lg shadow p-8 max-w-lg w-full mx-4 text-center">
    <h1 class="text-2xl font-bold text-red-700 mb-4">¿Cancelar esta cita?</h1>
    <div class="text-left bg-gray-50 rounded-lg p-4 mb-6 text-sm space-y-1">
        <p><strong>Cliente:</strong> {{ $cita->name_cliente }}</p>
        <p><strong>Servicio:</strong> {{ $cita->servicio?->nombre ?? '—' }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}</p>
        <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}</p>
    </div>
    <p class="text-sm text-gray-600 mb-6">Esta acción no se puede deshacer. Si solo quieres cambiar la fecha, usa el enlace de reprogramar.</p>
    <form method="POST" action="{{ route('citas.cancelar.enlace.confirmar', ['token' => $token]) }}">
        @csrf
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg mr-2">Sí, cancelar la cita</button>
        <a href="{{ url('/') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg inline-block">Volver</a>
    </form>
</div>
</body>
</html>
