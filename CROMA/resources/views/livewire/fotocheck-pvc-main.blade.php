<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Fotochecks PVC</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por titular o código..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Nuevo Fotocheck</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>N° FOTOCHECK</flux:table.column>
            <flux:table.column>TITULAR Y CÓDIGO</flux:table.column>
            <flux:table.column>CARGO E INSTITUCIÓN</flux:table.column>
            <flux:table.column>FOTOGRAFÍA</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($fotochecks as $item)
                <flux:table.row>
                    <flux:table.cell>
                        <span class="font-bold">#{{ $item->id_fotocheck }}</span>
                        <br>
                        <span class="text-xs text-gray-400">Detalle: {{ $item->id_detalle }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="block font-medium text-gray-800">{{ $item->nombre_titular ?? 'Sin nombre' }}</span>
                        @if($item->codigo_trabajador)
                            <flux:badge size="sm" color="zinc">Cód: {{ $item->codigo_trabajador }}</flux:badge>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="block text-sm text-gray-700">{{ $item->cargo ?? 'Cargo no definido' }}</span>
                        <span class="block text-xs text-gray-500">{{ $item->institucion ?? 'Institución no definida' }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->foto_url)
                            <a href="{{ $item->foto_url }}" target="_blank" class="text-violet-600 hover:underline flex items-center gap-1 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Ver Foto
                            </a>
                        @else
                            <span class="text-gray-400 text-xs italic">Sin foto</span>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_fotocheck }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_fotocheck }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $fotochecks->links() }}
    </div>

    <flux:modal name="modal-fotocheck" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Fotocheck' : 'Registrar Fotocheck' }}</flux:heading>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="id_detalle" type="number" label="ID Detalle Pedido" placeholder="Ej: 21" />
                <flux:input wire:model="codigo_trabajador" label="Código del Trabajador" placeholder="Ej: TRB-001" />
            </div>

            <flux:input wire:model="nombre_titular" label="Nombre del Titular" placeholder="Ej: Juan Pérez" />

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="cargo" label="Cargo" placeholder="Ej: Gerente General" />
                <flux:input wire:model="institucion" label="Institución / Empresa" placeholder="Ej: UPeU" />
            </div>

            <flux:input wire:model="foto_url" type="url" label="URL de la Fotografía" placeholder="Enlace a la foto del titular..." />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Datos' : 'Guardar Datos' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar registro?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar los datos de este Fotocheck PVC.<br>
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
