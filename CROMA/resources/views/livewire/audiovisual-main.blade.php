<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Edición Audiovisual</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por tipo de proyecto..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Nuevo Proyecto</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID / DETALLE</flux:table.column>
            <flux:table.column>PROYECTO</flux:table.column>
            <flux:table.column>DURACIÓN ESTIMADA</flux:table.column>
            <flux:table.column>RECURSOS</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($audiovisuales as $item)
                <flux:table.row>
                    <flux:table.cell>
                        <span class="font-bold text-gray-700">#{{ $item->id_edicion }}</span>
                        <br>
                        <span class="text-xs text-gray-400">Detalle: {{ $item->id_detalle }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="block font-medium">{{ $item->tipo }}</span>
                        <span class="block text-sm text-gray-500">Salida: {{ $item->formato_salida ?? 'No definido' }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->duracion_segundos)
                            <flux:badge size="sm" color="zinc">
                                {{ floor($item->duracion_segundos / 60) }}m {{ $item->duracion_segundos % 60 }}s
                            </flux:badge>
                        @else
                            <span class="text-gray-400 text-sm">Por definir</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->archivo_fuente)
                            <a href="{{ $item->archivo_fuente }}" target="_blank" class="text-violet-600 hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                Material RAW
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Sin recursos</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_edicion }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_edicion }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $audiovisuales->links() }}
    </div>

    <flux:modal name="modal-audiovisual" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Proyecto Audiovisual' : 'Registrar Nuevo Proyecto' }}</flux:heading>
            </div>

            <flux:input wire:model="id_detalle" type="number" label="ID Detalle Pedido" placeholder="Asociar al pedido..." />

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="tipo" label="Tipo de Edición" placeholder="Ej: Reel, Spot Publicitario" />
                <flux:input wire:model="formato_salida" label="Formato de Salida" placeholder="Ej: MP4, MOV 4K" />
            </div>

            <flux:input wire:model="duracion_segundos" type="number" label="Duración Total (en Segundos)" placeholder="Ej: 120 (para 2 minutos)" />

            <flux:input wire:model="archivo_fuente" type="url" label="Ruta del Material (RAW/Fuentes)" placeholder="Enlace a Drive, WeTransfer, etc." />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Proyecto' : 'Guardar Proyecto' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Borrar registro?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar este proyecto audiovisual.<br>
                    Esta acción no se puede revertir.
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
