<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Servicios y precios
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 underline text-sm">&larr; Volver al panel</a>

                    @if (session('succes'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                            {{ session('succes') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.servicios.update') }}" class="mt-4">
                        @csrf
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-2">Servicio</th>
                                    <th>Precio ($)</th>
                                    <th>Duración (min)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicios as $servicio)
                                    <tr class="border-b">
                                        <td class="py-2 font-semibold">{{ $servicio->nombre }}</td>
                                        <td>
                                            <input type="number" name="servicios[{{ $servicio->id }}][precio]" min="0" step="0.01"
                                                   value="{{ $servicio->precio }}"
                                                   class="border rounded px-2 py-1 w-24">
                                        </td>
                                        <td>
                                            <input type="number" name="servicios[{{ $servicio->id }}][duracion]" min="5" max="240"
                                                   value="{{ $servicio->duracion }}"
                                                   class="border rounded px-2 py-1 w-20">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-6">
                            <button class="bg-blue-600 text-white px-6 py-2 rounded">Guardar precios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
