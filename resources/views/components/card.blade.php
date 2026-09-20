<div>
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
        <img src="https://images.unsplash.com/photo-1585747860715-2ba37e788b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Corte de cabello"       class="h-48 w-full object-cover">
         <div class="p-6">
             <h3 class="text-xl font-bold text-gray-800">{{ $slot }}</h3>
              <p class="text-gray-500 mt-2">{{ $descripcion }}</p>
              <div class="mt-4 flex justify-between items-center">
                <span class="text-amber-600 font-bold text-xl">{{$precio}}</span>
                  <a href="#reserva" class="text-sm bg-gray-800 hover:bg-amber-600 text-white px-4 py-2 rounded-full transition">Reservar</a>
              </div>
         </div>
    </div>  
</div>