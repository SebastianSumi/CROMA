<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Lanyards (Cintas)</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por texto impreso o color..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Nuevo Lanyard</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>N° LANYARD</flux:table.column>
            <flux:table.column>COLOR BASE</flux:table.column>
            <flux:table.column>TEXTO A IMPRIMIR</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($lanyards as $item)
                <flux:table.row>
                    <flux:table.cell>
                        <span class="font-bold">#{{ $item->id_lanyard }}</span>
                        <br>
                        <span class="text-xs text-gray-400">Detalle: {{ $item->id_detalle }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->color)
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full border border-gray-300 shadow-sm" style="background-color: {{ strtolower($item->color) }};"></span>
                                {{ $item->color }}
                            </div>
                        @else
                            <span class="text-gray-400 italic">No especificado</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->texto_impreso)
                            <span class="font-medium text-gray-700">"{{ $item->texto_impreso }}"</span>
                        @else
                            <span class="text-gray-400 italic">Sin texto (Solo color)</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_lanyard }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_lanyard }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $lanyards->links() }}
    </div>

    <flux:modal name="modal-lanyard" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Lanyard' : 'Registrar Lanyard' }}</flux:heading>
            </div>

            <flux:input wire:model="id_detalle" type="number" label="ID Detalle Pedido" placeholder="Ej: 12" />

            <flux:input wire:model="color" label="Color de la Cinta" placeholder="Ej: Azul Marino, Rojo, Blanco" />

            <flux:textarea wire:model="texto_impreso" label="Texto a Imprimir" placeholder="Ej: STAFF 2026, INVITADO ESPECIAL" />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Lanyard' : 'Guardar Lanyard' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar registro?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar este diseño de cinta (lanyard).<br>
                    Esta acción no se puede deshacer.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button wire:click="eliminar()" type="submit" variant="danger">Sí, eliminar</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
