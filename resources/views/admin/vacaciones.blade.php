<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Días bloqueados
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 underline text-sm">&larr; Volver al panel</a>

                    @if (session('succes'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                            {{ session('succes') }}
                        </div>
                    @endif

                    <h3 class="font-bold mt-4 mb-2">Bloquear una fecha</h3>
                    <form method="POST" action="{{ route('admin.vacaciones.store') }}" class="flex flex-wrap gap-3 items-end">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-600">Fecha</label>
                            <input type="date" name="fecha" min="{{ date('Y-m-d') }}" required
                                   class="border rounded px-3 py-2">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm text-gray-600">Motivo (opcional)</label>
                            <input type="text" name="razon" maxlength="255" placeholder="Vacaciones, evento…"
                                   class="border rounded px-3 py-2 w-full">
                        </div>
                        <button class="bg-blue-600 text-white px-6 py-2 rounded">Bloquear</button>
                    </form>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-bold mb-4">Fechas bloqueadas</h3>
                    @if ($vacaciones->isEmpty())
                        <p class="text-gray-500">No hay fechas bloqueadas.</p>
                    @else
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-2">Fecha</th>
                                    <th>Motivo</th>
                                    <th class="text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vacaciones as $v)
                                <tr class="border-b">
                                    <td class="py-2">{{ \Carbon\Carbon::parse($v->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $v->razon ?? '—' }}</td>
                                    <td class="text-right">
                                        <form method="POST" action="{{ route('admin.vacaciones.destroy', $v) }}"
                                              onsubmit="return confirm('¿Desbloquear esta fecha?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Desbloquear</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
