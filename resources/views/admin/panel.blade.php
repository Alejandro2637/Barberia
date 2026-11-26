<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel del día — {{ \Carbon\Carbon::today()->format('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('succes'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('succes') }}
                </div>
            @endif

            <div class="flex gap-4">
                <a href="{{ route('admin.horarios') }}" class="bg-gray-800 text-white px-4 py-2 rounded">Horarios</a>
                <a href="{{ route('admin.vacaciones') }}" class="bg-gray-800 text-white px-4 py-2 rounded">Días bloqueados</a>
                <a href="{{ route('admin.servicios') }}" class="bg-gray-800 text-white px-4 py-2 rounded">Servicios y precios</a>
                <a href="{{ route('admin.datos') }}" class="bg-gray-800 text-white px-4 py-2 rounded">Datos y dirección</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Citas de hoy ({{ $citasHoy->count() }})</h3>
                    @if ($citasHoy->isEmpty())
                        <p class="text-gray-500">No hay citas para hoy.</p>
                    @else
                        <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-2">Hora</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($citasHoy as $cita)
                                <tr class="border-b">
                                    <td class="py-2 font-semibold">{{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}</td>
                                    <td>{{ $cita->name_cliente }}</td>
                                    <td>{{ $cita->phone_cliente }}</td>
                                    <td>{{ $cita->servicio?->nombre ?? '—' }}</td>
                                    <td>
                                        @php
                                            $badge = match($cita->estado) {
                                                \App\Enums\EstadoCitas::Cancelado => 'bg-red-100 text-red-800',
                                                \App\Enums\EstadoCitas::Completado => 'bg-blue-100 text-blue-800',
                                                default => 'bg-green-100 text-green-800',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $badge }}">
                                            {{ $cita->estado->label() }}
                                        </span>
                                    </td>
                                    <td class="text-right space-x-2">
                                        @if ($cita->estado === \App\Enums\EstadoCitas::Confirmado)
                                            <form method="POST" action="{{ route('citas.completar', $cita) }}" class="inline">
                                                @csrf
                                                <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Completar</button>
                                            </form>
                                            <form method="POST" action="{{ route('citas.cancelar', $cita) }}" class="inline"
                                                  onsubmit="return confirm('¿Cancelar esta cita?')">
                                                @csrf
                                                <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Cancelar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Próximas citas</h3>
                    @if ($proximas->isEmpty())
                        <p class="text-gray-500">No hay citas próximas.</p>
                    @else
                        <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-2">Fecha</th>
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proximas as $cita)
                                <tr class="border-b">
                                    <td class="py-2">{{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}</td>
                                    <td>{{ $cita->name_cliente }}</td>
                                    <td>{{ $cita->servicio?->nombre ?? '—' }}</td>
                                    <td class="text-right">
                                        <form method="POST" action="{{ route('citas.cancelar', $cita) }}" class="inline"
                                              onsubmit="return confirm('¿Cancelar esta cita?')">
                                            @csrf
                                            <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Cancelar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
