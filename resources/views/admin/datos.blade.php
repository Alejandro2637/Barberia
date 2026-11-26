<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Datos y dirección
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

                    <form method="POST" action="{{ route('admin.datos.update') }}" class="mt-4">
                        @csrf
                        <label class="block text-gray-700 font-medium mb-1">Dirección de la barbería</label>
                        <input type="text" name="direccion"
                               value="{{ old('direccion', $datos?->direccion) }}"
                               placeholder="Calle, número, ciudad"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <p class="text-sm text-gray-500 mt-1">Esta es la dirección que sale en la portada y en el mapa. Si la dejas vacía, el mapa no se muestra.</p>

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach>
                                </ul>
                            </div>
                        @endif

                        <div class="mt-6">
                            <button class="bg-blue-600 text-white px-6 py-2 rounded">Guardar dirección</button>
                        </div>
                    </form>

                    @if ($datos?->direccion)
                        <p class="text-gray-700 font-medium mt-8 mb-2">Así se ve en el mapa:</p>
                        <iframe src="https://www.google.com/maps?q={{ urlencode($datos->direccion) }}&output=embed" class="w-full h-64 rounded-md" loading="lazy"></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
