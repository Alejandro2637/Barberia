@extends('layouts.app')

@section('title', 'Barbería Jonathan - Estilo y Tradición')

@section('content')
<main class="bg-gray-50">
    <!-- Hero Section (Portada principal) -->
    <section class="relative bg-gradient-to-r from-gray-900 to-gray-800 text-white">
        <div class="relative z-20 max-w-7xl px-2  lg:px-2 py-4 md:py-3 flex space-x-2">
            <div class="text-center md:text-left md:w-2/3 ml-8">
                <h1 class="text-4xl md:text-6xl font-bold font-serif mb-4">
                    Barbería <span class="text-amber-500">Jonathan</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8">
                    Cortes clásicos, tendencia moderna y atención personalizada.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="#reserva" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-3 rounded-full transition shadow-lg text-center">
                        Reserva tu turno
                    </a>
                    <a href="#servicios" class="border border-white hover:bg-white hover:text-gray-900 text-white font-semibold px-6 py-3 rounded-full transition text-center">
                        Ver servicios
                    </a>
                </div>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="barbero pelando un cliente" class=" w-56 h-auto object-center">
            </div>
        </div>
        <!------------------------------- Imagen de fondo opcional (reemplazar por tu imagen) -------------------------------------------------------->
       <!-- <div class="absolute inset-0 z-0">
            <img src="#" alt="Barberías" class="w-full h-full object-cover">
        </div>--->
    </section>

    <!-- Sección Nosotros (breve historia) -->
    <section id="nosotros" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold font-serif text-gray-800 mb-4">Sobre nosotros</h2>
                    <div class="w-20 h-1 bg-amber-500 mb-6"></div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        En Barbería Jonathan combinamos la tradición de las barberías clásicas con las últimas tendencias. 
                        Más de 10 años ofreciendo cortes de cabello, arreglo de barba y cuidado personal para hombres.
                    </p>
                    <p class="text-gray-600 mt-4">
                        Jonathan es expertos en técnicas de tijera, navaja y máquina. Te asesoramos para que encuentres 
                        el estilo que mejor te representa.
                    </p>
                    <div class="mt-8 flex gap-6">
                        <div>
                            <span class="text-amber-600 font-bold text-2xl">+2000</span>
                            <p class="text-gray-500">Clientes felices</p>
                        </div>
                        <div>
                            <span class="text-amber-600 font-bold text-2xl">+15</span>
                            <p class="text-gray-500">Años de experiencia</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Barbería" class="w-64 h-auto object-cover ">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Servicios (cards) -->
    <section id="servicios" class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold font-serif text-gray-800">Nuestros servicios</h2>
                <div class="w-20 h-1 bg-amber-500 mx-auto mt-2 mb-4"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">Elige el servicio que necesites y reserva tu cita en minutos.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Servicio 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1585747860715-2ba37e788b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Corte de cabello" class="h-48 w-full object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">Corte de cabello</h3>
                        <p class="text-gray-500 mt-2">Corte a tijera, máquina o degradado. Incluye lavado y asesoría de estilo.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-amber-600 font-bold text-xl">$300</span>
                            <a href="#reserva" class="text-sm bg-gray-800 hover:bg-amber-600 text-white px-4 py-2 rounded-full transition">Reservar</a>
                        </div>
                    </div>
                </div>
                <!-- Servicio 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Arreglo de barba" class="h-48 w-full object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">Arreglo de barba</h3>
                        <p class="text-gray-500 mt-2">Perfilado, recorte con navaja, toallas calientes y aceites esenciales.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-amber-600 font-bold text-xl">$200</span>
                            <a href="#reserva" class="text-sm bg-gray-800 hover:bg-amber-600 text-white px-4 py-2 rounded-full transition">Reservar</a>
                        </div>
                    </div>
                </div>
                <!-- Servicio 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1622286342621-4bd786c2447c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Combo completo" class="h-48 w-full object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">Combo completo</h3>
                        <p class="text-gray-500 mt-2">Corte + barba + mascarilla facial + cerveza o café.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-amber-600 font-bold text-xl">$500</span>
                            <a href="#reserva" class="text-sm bg-gray-800 hover:bg-amber-600 text-white px-4 py-2 rounded-full transition">Reservar</a>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </section>

    <!-- Sección de Reserva (formulario simple) -->
    <section id="reserva" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold font-serif text-gray-800">Reserva tu cita</h2>
                    <div class="w-20 h-1 bg-amber-500 my-4"></div>
                    <p class="text-gray-600 mb-6">
                        Elige el servicio, día y hora. Te confirmaremos por WhatsApp o email.
                    </p>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-2">✂️ Cortes sin turno previo (sujeto a disponibilidad)</li>
                        <li class="flex items-center gap-2">⏱️ Turnos cada 45 minutos</li>
                        <li class="flex items-center gap-2">📍 Av. Siempreviva 123, Local 5</li>
                    </ul>
                    <div class="mt-6 h-48 min-h-auto rounded-md bg-gray-100 font-semibold content-between">
                        <x-input-label class="text-gray-700 font-medium text-center">Nuestra ubicación</x-input-label>
                    </div>
                </div>
        
                <div class="bg-gray-100 p-6 rounded-xl shadow-md"> 
                    <form action="{{ route('index.store') }}" method="POST" class="space-y-4" >
                        @csrf
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Nombre completo</label>
                            <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-1" required>
                        </div>
                        <div>
                           <label class="block text-gray-700 font-medium mb-1">Email</label>
                           <input type="email" name="email" class="w-full border-gray-300 rounded-lg px-4 py-1" required>                          
                        </div>                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Teléfono / WhatsApp</label>
                            <input type="tel" name="phone" class="w-full border border-gray-300 rounded-lg px-4 py-1" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Servicio</label>
                            <select name="service" class="w-full border border-gray-300 rounded-lg px-4 py-1">
                                <option>Corte de cabello - $300</option>
                                <option>Arreglo de barba - $200</option>
                                <option>Combo completo - $500</option>
                            </select>
                        </div>
                        <div class="flex justify-center">
                            <div  class="mr-16">
                                <label class="block text-gray-700 font-medium mb-1">Fecha</label>
                                <input type="date" name="fecha_cita" class="w-50% border border-gray-300 rounded-lg px-4 py-1" required>                           
                            </div>
                            <div class="ml-10">
                                <label class="block text-gray-700 font-medium mb-1">Hora</label>
                                <input type="time" name="hora_cita" class="w-50% border border-gray-300 rounded-lg px-4 py-1" required>
                            </div>
                            <div class="ml-10 mt-5 content-center">
                                <input type="checkbox" name="domicilio" class="p-2 rounded-lg border-b-slate-900 ">
                                <label class=" text-gray-700 font-medium mb-1 inline">Domicilio</label>
                            </div>
                        </div>
                        <!---domicilio--->
                        <div class="direccion  hidden inline-block ">
                            <div class="flex space-x-3 m-2">
                                <div class=" flex">
                                    <label class="block text-gray-700 m-1">Calle</label>
                                    <input type="text" class="w-20 h-7 border-gray-300 rounded-lg px-1 py-1">
                                </div> 
                                <div class=" flex">
                                    <label class="block text-gray-700 m-1">entre</label>
                                    <input type="text" class="w-20 h-7 border-gray-300 rounded-lg px-1 py-1">
                                </div>                                                 
                                <div class="flex">
                                     <label class="block text-gray-700 m-1">Edif</label>
                                     <input type="text" class="w-20 h-7  border-gray-300 rounded-lg  px-1 py-1 ">
                                </div> 
                                <div class=" flex">
                                     <label class="block text-gray-700 m-1">Apto</label>
                                     <input type="text" class="w-20 h-7 border-gray-300 rounded-lg  px-1 py-1 ">
                               </div> 
                            </div>
                            <div class="flex space-x-2">
                               <div ml-10 class="flex">
                                   <label class="block text-gray-700 m-1">Rpto</label>
                                   <input type="text" class="w-24 h-7 border-gray-300 rounded-lg  px-1 py-1">
                               </div>  
                               <div class=" flex">
                                  <label class="block text-gray-700 m-1">Mpio</label>
                                  <input type="text" class="w-28 h-7 border-gray-300 rounded-lg px-1 py-1">
                               </div>
                            </div>   
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="w-auto p-2 bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 rounded-full transition flex text-center">Solicitar turno</button>
                        </div>
                        
                    </form>
                    <p class="text-xs text-gray-400 text-center mt-4">Te contactaremos a la brevedad para confirmar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios (opcional) -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold font-serif text-gray-800">Lo que dicen nuestros clientes</h2>
            <div class="w-20 h-1 bg-amber-500 mx-auto my-4"></div>
            <div class="grid md:grid-cols-3 gap-8 mt-10">
                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-600">"Excelente atención, muy profesionales. El corte quedó perfecto."</p>
                    <p class="font-bold mt-4">- Carlos G.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-600">"La mejor barbería de la zona. El combo completo es 10/10."</p>
                    <p class="font-bold mt-4">- Andrés M.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-600">"Ambiente relajado, música buena y barberos atentos. Volveré."</p>
                    <p class="font-bold mt-4">- Fernanda L.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer simple -->
        <!-- Footer con redes sociales -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex justify-between items-center">
                <!-- Texto copyright -->
                <div class="text-center md:text-left">
                    <p>© 2025 Barbería Jonathan - Todos los derechos reservados.</p>
                    <p class="text-gray-400 text-sm mt-1">📍 Av. Siempreviva 123 | 📞 +53 58384595 | ✉️ contacto@barberiajonathan.cl</p>
                </div>
                <!-- Íconos sociales -->
                <div class="flex justify-center md:justify-end space-x-6 m-3">
                    <a href="#" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-amber-400 transition" aria-label="YouTube">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.376.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.376-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-amber-400 transition" aria-label="Instagram">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                        </svg>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-amber-400 transition" aria-label="WhatsApp">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.031 2.016c-5.016 0-9.047 4.031-9.047 9.047 0 1.594.422 3.094 1.172 4.453L2.25 21.75l6.281-1.5a9.036 9.036 0 0 0 4.453 1.172c5.016 0 9.047-4.031 9.047-9.047s-4.031-9.047-9.047-9.047zM9.422 8.719c.141 0 .281.047.422.141.141.094.328.281.422.422.234.375.422.75.609 1.172.047.094.047.234-.047.328l-.234.281c-.094.094-.141.188-.234.281-.094.094-.094.188-.047.281.188.328.422.656.703.938.281.281.609.516.938.703.094.047.188.047.281-.047.094-.094.188-.141.281-.234.094-.094.188-.094.281-.047.422.188.797.375 1.172.609.094.047.188.094.281.141.094.047.141.141.094.234l-.047.094c-.094.234-.234.422-.422.563-.188.141-.422.234-.656.234-.328 0-.656-.094-.938-.281-1.172-.703-2.203-1.734-2.906-2.906-.188-.281-.281-.609-.281-.938 0-.234.094-.469.234-.656.141-.188.328-.328.563-.422.094-.047.188-.094.234-.141.094-.094.094-.188.047-.281-.047-.094-.094-.141-.141-.234-.094-.234-.188-.469-.281-.703-.094-.234-.094-.469-.094-.703 0-.328.094-.656.281-.938.141-.234.328-.422.563-.563.234-.141.516-.234.797-.234.094 0 .188.047.281.141z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
<script>

</script>
</main>
@endsection
