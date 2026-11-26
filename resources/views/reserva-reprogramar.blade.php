<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reprogramar cita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white rounded-lg shadow p-8 max-w-lg w-full mx-4">
    <h1 class="text-2xl font-bold text-center mb-4">Reprogramar cita</h1>
    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-sm space-y-1">
        <p><strong>Cliente:</strong> {{ $cita->name_cliente }}</p>
        <p><strong>Servicio:</strong> {{ $cita->servicio?->nombre ?? '—' }}</p>
        <p><strong>Fecha actual:</strong> {{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}</p>
    </div>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('citas.reprogramar.update', ['token' => $token]) }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 font-medium mb-1">Nueva fecha</label>
            <input type="date" name="fecha_cita" value="{{ old('fecha_cita', \Carbon\Carbon::parse($cita->fecha_cita)->format('Y-m-d')) }}" min="{{ today()->toDateString() }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Nueva hora (HH:MM)</label>
            <input type="time" name="hora_cita" value="{{ old('hora_cita', \Carbon\Carbon::parse($cita->hora_cita)->format('H:i')) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
            <p class="text-sm text-gray-500 mt-1">Si el turno ya está ocupado, el sistema te avisará y podrás elegir otro.</p>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg">Guardar nueva fecha</button>
    </form>
    <p class="text-xs text-gray-500 mt-4 text-center">Al reprogramar, tus enlaces de gestión cambian: recibirás un correo nuevo con los enlaces actualizados.</p>
</div>
</body>
</html>
