<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Impresión Offset</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por material (Ej: Couché, Folcote)..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Nuevo Servicio Offset</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>N° ORDEN</flux:table.column>
            <flux:table.column>MATERIAL Y ACABADO</flux:table.column>
            <flux:table.column>PÁGINAS</flux:table.column>
            <flux:table.column>PRENSA / DISEÑO</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($offsets as $item)
                <flux:table.row>
                    <flux:table.cell>
                        <span class="font-bold text-gray-700">#{{ $item->id_offset }}</span>
                        <br>
                        <span class="text-xs text-gray-400">Detalle: {{ $item->id_detalle }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="block font-medium">{{ $item->tipo_material }}</span>
                        @if($item->acabado)
                            <span class="block text-sm text-gray-500">Acabado: {{ $item->acabado }}</span>
                        @else
                            <span class="block text-sm text-gray-400 italic">Sin acabados especiales</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->num_paginas)
                            <flux:badge size="sm" color="blue">{{ $item->num_paginas }} págs.</flux:badge>
                        @else
                            <span class="text-sm text-gray-500">N/A (Lámina/Volante)</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <a href="{{ $item->diseno_url }}" target="_blank" class="text-violet-600 hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Ver Placas/PDF
                        </a>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_offset }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_offset }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $offsets->links() }}
    </div>

    <flux:modal name="modal-offset" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Servicio Offset' : 'Registrar Servicio Offset' }}</flux:heading>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="id_detalle" type="number" label="ID Detalle Pedido" placeholder="Ej: 102" />
                <flux:input wire:model="num_paginas" type="number" label="N° de Páginas" placeholder="Dejar vacío si es volante" />
            </div>

            <flux:input wire:model="tipo_material" label="Tipo de Material" placeholder="Ej: Papel Couché 300g, Folcote Calibre 12" />

            <flux:input wire:model="acabado" label="Acabados (Opcional)" placeholder="Ej: Plastificado mate, Barniz UV sectorizado, Troquelado" />

            <flux:input wire:model="diseno_url" type="url" label="URL del Diseño (PDF/Placas)" placeholder="Enlace al archivo de producción..." />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Orden' : 'Guardar Orden' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Borrar orden de producción?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar esta configuración de impresión offset.<br>
                    Esta acción no se puede deshacer y perderás los enlaces a las placas de diseño.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button wire:click="eliminar()" type="submit" variant="danger">Sí, eliminar orden</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
