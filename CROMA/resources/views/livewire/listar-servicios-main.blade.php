<div>
    <div class="mb-10 text-center md:text-left border-b-2 pb-4 border-violet-500">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Centro de Producción</h1>
        <p class="text-gray-500 mt-2 text-lg">Selecciona un área de servicio para gestionar los pedidos en curso.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($modulos as $modulo)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group relative cursor-pointer" wire:click="irAModulo('{{ $modulo['ruta'] }}')">

                @php
                    $bgColors = [
                        'blue' => 'from-blue-500 to-blue-400',
                        'cyan' => 'from-cyan-500 to-cyan-400',
                        'fuchsia' => 'from-fuchsia-500 to-fuchsia-400',
                        'purple' => 'from-purple-500 to-purple-400',
                        'rose' => 'from-rose-500 to-rose-400',
                        'emerald' => 'from-emerald-500 to-emerald-400',
                    ];
                    $gradient = $bgColors[$modulo['color']] ?? 'from-gray-500 to-gray-400';
                @endphp
                <div class="h-3 w-full bg-gradient-to-r {{ $gradient }}"></div>

                <div class="p-6 flex-grow flex flex-col">

                    <h2 class="text-2xl font-bold text-gray-800 leading-tight mb-3 group-hover:text-violet-600 transition-colors">
                        {{ $modulo['nombre'] }}
                    </h2>

                    <p class="text-gray-500 flex-grow mb-6">
                        {{ $modulo['descripcion'] }}
                    </p>

                    <div class="mt-auto">
                        <flux:button class="w-full flex justify-center bg-gray-50 hover:bg-violet-50 hover:text-violet-700 transition-colors border-0 shadow-none font-semibold">
                            Entrar al área de trabajo &rarr;
                        </flux:button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
