<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar cita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-2">Reservar cita</h1>
    <p class="text-center text-gray-600 mb-6">Paso <span id="paso-num">1</span> de 3</p>

    <!-- Indicador de pasos -->
    <div class="flex mb-8">
        <div class="flex-1 text-center font-semibold text-blue-600" id="ind-1">1. Servicio</div>
        <div class="flex-1 text-center text-gray-400" id="ind-2">2. Fecha y hora</div>
        <div class="flex-1 text-center text-gray-400" id="ind-3">3. Confirmación</div>
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

    <form method="POST" action="{{ route('reservar.store') }}" id="form-reserva" class="bg-white rounded-lg shadow p-6">
        @csrf

        <!-- PASO 1: servicio -->
        <div id="paso-1">
            <label class="block text-gray-700 font-medium mb-2">Elige el servicio</label>
            <select name="servicio_id" id="servicio_id" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                <option value="">-- Selecciona --</option>
                @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                        {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 0) }} ({{ $servicio->duracion }} min)
                    </option>
                @endforeach
            </select>
            @if ($servicios->isEmpty())
                <p class="text-sm text-red-600 mt-2">Aún no hay servicios registrados.</p>
            @endif
            <div class="mt-6 text-right">
                <button type="button" onclick="irPaso(2)" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Siguiente</button>
            </div>
        </div>

        <!-- PASO 2: fecha y hora -->
        <div id="paso-2" class="hidden">
            <label class="block text-gray-700 font-medium mb-2">Fecha</label>
            <input type="date" name="fecha_cita" id="fecha_cita" value="{{ old('fecha_cita') }}"
                   min="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>

            <p id="msg-disponibilidad" class="text-sm text-gray-600 mt-3"></p>

            <label class="block text-gray-700 font-medium mt-4 mb-2">Hora disponible</label>
            <div id="turnos" class="grid grid-cols-4 gap-2"></div>
            <input type="hidden" name="hora_cita" id="hora_cita" value="{{ old('hora_cita') }}" required>

            <div class="mt-6 flex justify-between">
                <button type="button" onclick="irPaso(1)" class="bg-gray-300 px-6 py-2 rounded-lg">Atrás</button>
                <button type="button" onclick="irPaso(3)" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Siguiente</button>
            </div>
        </div>

        <!-- PASO 3: datos y confirmación -->
        <div id="paso-3" class="hidden">
            <div class="bg-gray-50 rounded-lg p-4 mb-4 text-sm">
                <p><strong>Servicio:</strong> <span id="res-servicio"></span></p>
                <p><strong>Fecha:</strong> <span id="res-fecha"></span></p>
                <p><strong>Hora:</strong> <span id="res-hora"></span></p>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Teléfono / WhatsApp</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <button type="button" onclick="irPaso(2)" class="bg-gray-300 px-6 py-2 rounded-lg">Atrás</button>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg">Confirmar reserva</button>
            </div>
        </div>
    </form>
</div>

<script>
function irPaso(n) {
    if (n === 2 && !document.getElementById('servicio_id').value) {
        alert('Elige un servicio primero.');
        return;
    }
    if (n === 3 && !document.getElementById('hora_cita').value) {
        alert('Elige fecha y hora primero.');
        return;
    }
    [1, 2, 3].forEach(i => {
        document.getElementById('paso-' + i).classList.toggle('hidden', i !== n);
        const ind = document.getElementById('ind-' + i);
        ind.classList.toggle('text-blue-600', i === n);
        ind.classList.toggle('font-semibold', i === n);
        ind.classList.toggle('text-gray-400', i !== n);
    });
    document.getElementById('paso-num').textContent = n;

    if (n === 3) {
        const sel = document.getElementById('servicio_id');
        document.getElementById('res-servicio').textContent = sel.options[sel.selectedIndex].text;
        document.getElementById('res-fecha').textContent = document.getElementById('fecha_cita').value;
        document.getElementById('res-hora').textContent = document.getElementById('hora_cita').value;
    }
}

document.getElementById('fecha_cita').addEventListener('change', function () {
    const fecha = this.value;
    const cont = document.getElementById('turnos');
    const msg = document.getElementById('msg-disponibilidad');
    document.getElementById('hora_cita').value = '';
    cont.innerHTML = '';
    if (!fecha) return;
    msg.textContent = 'Cargando turnos…';
    fetch('{{ route('disponibilidad') }}?fecha=' + fecha)
        .then(r => r.json())
        .then(data => {
            if (!data.abierto) {
                msg.textContent = data.motivo || 'No disponible';
                return;
            }
            const libres = data.turnos.filter(t => t.disponible);
            msg.textContent = libres.length
                ? libres.length + ' turnos disponibles'
                : 'No quedan turnos libres ese día.';
            data.turnos.forEach(t => {
                const b = document.createElement('button');
                b.type = 'button';
                b.textContent = t.hora;
                b.disabled = !t.disponible;
                b.className = 'px-2 py-2 rounded-lg border text-sm ' + (t.disponible
                    ? 'border-blue-500 hover:bg-blue-500 hover:text-white'
                    : 'bg-gray-100 text-gray-400 cursor-not-allowed');
                b.onclick = () => {
                    document.getElementById('hora_cita').value = t.hora;
                    cont.querySelectorAll('button').forEach(x => x.classList.remove('bg-blue-600', 'text-white'));
                    b.classList.add('bg-blue-600', 'text-white');
                };
                cont.appendChild(b);
            });
        })
        .catch(() => { msg.textContent = 'No se pudo cargar la disponibilidad.'; });
});

// Si el formulario volvió con errores, reabrir el paso 2 y recargar turnos
@if (old('fecha_cita'))
    irPaso(2);
    document.getElementById('fecha_cita').dispatchEvent(new Event('change'));
@endif
</script>
</body>
</html>
