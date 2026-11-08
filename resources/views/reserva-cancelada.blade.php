<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cita cancelada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white rounded-lg shadow p-8 max-w-lg w-full mx-4 text-center">
    @if ($yaCancelada)
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Esta cita ya estaba cancelada</h1>
        <p class="text-sm text-gray-600">No se realizó ningún cambio.</p>
    @else
        <h1 class="text-2xl font-bold text-red-700 mb-4">Cita cancelada</h1>
        <p class="text-sm text-gray-600">
            La cita de {{ $cita->name_cliente }} para el
            {{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}
            a las {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}
            fue cancelada.
        </p>
    @endif
    <div class="mt-6">
        <a href="{{ route('reservar') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Reservar otra cita</a>
    </div>
</div>
</body>
</html>
