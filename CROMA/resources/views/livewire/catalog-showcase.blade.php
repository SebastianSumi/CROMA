<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">Catálogo de Productos</h1>
        <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
            Explora nuestra variedad de opciones o inspírate con nuestra galería de trabajos anteriores.
        </p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-gray-200 pb-4">

        <div class="flex space-x-8">
            <button
                wire:click="changeView('catalog')"
                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $view === 'catalog' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <svg class="w-5 h-5 inline-block mr-1 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                Lista de Precios
            </button>
            <button
                wire:click="changeView('portfolio')"
                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $view === 'portfolio' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <svg class="w-5 h-5 inline-block mr-1 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Trabajos Anteriores
            </button>
        </div>

        <div class="w-full md:w-96">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input
                    wire:model.live="search"
                    type="text"
                    placeholder="Buscar producto..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                />
            </div>
        </div>
    </div>

    @if($view === 'catalog')
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($productos as $producto)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden flex flex-col">
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $producto->nombre }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                S/. {{ number_format($producto->precio_base, 2) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-3">
                            {{ $producto->descripcion ?? 'Producto disponible. Contáctanos para más detalles sobre materiales y acabados.' }}
                        </p>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 mt-auto">
                        <a href="https://wa.me/TUNUMERODEWHATSAPP?text=Hola, estoy interesado en el producto: {{ $producto->nombre }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cotizar este producto
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay productos</h3>
                    <p class="mt-1 text-sm text-gray-500">No encontramos productos que coincidan con tu búsqueda.</p>
                </div>
            @endforelse
        </div>

    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($muestras as $muestra)
                <div class="group block relative overflow-hidden rounded-xl bg-gray-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <img
                        src="{{ asset($muestra->imagen_url) }}"
                        alt="Muestra de {{ $muestra->titulo }}"
                        class="object-cover w-full h-64 group-hover:scale-105 transition-transform duration-500 ease-in-out"
                        onerror="this.src='https://placehold.co/400x300?text=Muestra+No+Disponible'"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-90"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <p class="text-sm font-bold text-indigo-300 truncate uppercase tracking-wider">{{ $muestra->titulo }}</p>
                        <p class="text-white text-xs mt-1 line-clamp-2">{{ $muestra->descripcion ?? 'Muestra de trabajo realizado.' }}</p>

                        @if($muestra->producto)
                            <span class="inline-block mt-2 px-2 py-1 bg-indigo-600/80 backdrop-blur-sm text-white text-[10px] font-bold rounded">
                                {{ $muestra->producto->nombre }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aún no hay galería</h3>
                    <p class="mt-1 text-sm text-gray-500">Pronto subiremos fotografías de nuestros trabajos realizados.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>
