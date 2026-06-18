<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Trabajos Anteriores (Portafolio)</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por título o descripción..." icon="magnifying-glass" class="flex-1"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Subir Muestra</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>MUESTRA</flux:table.column>
            <flux:table.column>DETALLES</flux:table.column>
            <flux:table.column>CATEGORÍA / FECHA</flux:table.column>
            <flux:table.column>ESTADO</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($trabajos as $item)
                <flux:table.row>
                    <flux:table.cell>
                        <img src="{{ $item->imagen_url }}" alt="{{ $item->titulo }}" class="w-16 h-16 object-cover rounded shadow-sm border border-gray-200" onerror="this.src='https://placehold.co/100x100?text=Error'">
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="block font-bold text-gray-800">{{ $item->titulo }}</span>
                        <span class="block text-xs text-gray-500 max-w-xs truncate">{{ $item->descripcion ?? 'Sin descripción' }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="block font-medium text-sm text-indigo-600">{{ $item->producto ? $item->producto->nombre : 'Sin categorizar' }}</span>
                        <span class="block text-xs text-gray-400 mt-1">{{ $item->fecha_realizacion ? \Carbon\Carbon::parse($item->fecha_realizacion)->format('d/m/Y') : '-' }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->activo)
                            <flux:badge size="sm" color="green" inset>Visible en Galería</flux:badge>
                        @else
                            <flux:badge size="sm" color="red" inset>Oculto</flux:badge>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_trabajo }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_trabajo }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $trabajos->links() }}
    </div>

    <flux:modal name="modal-trabajo" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Muestra de Trabajo' : 'Registrar Nuevo Trabajo' }}</flux:heading>
            </div>

            <flux:input wire:model="titulo" label="Título del Trabajo" placeholder="Ej: Diseño de Logo para Barbería..." />

            <flux:textarea wire:model="descripcion" label="Descripción (Opcional)" placeholder="Detalles de la técnica, materiales o cliente..." rows="3" />

            <flux:input wire:model="imagen_url" type="url" label="URL de la Fotografía" placeholder="https://..." />

            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="producto_id" label="Vincular a Producto">
                    <option value="">Seleccione un producto (Opcional)</option>
                    @foreach($productos_disponibles as $prod)
                        <option value="{{ $prod->id_producto }}">{{ $prod->nombre }}</option>
                    @endforeach
                </flux:select>

                <flux:input wire:model="fecha_realizacion" type="date" label="Fecha de Realización" />
            </div>

            <flux:select wire:model="activo" label="Visibilidad">
                <option value="1">Mostrar al público en la galería</option>
                <option value="0">Ocultar de la vista pública</option>
            </flux:select>

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Trabajo' : 'Guardar Trabajo' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar esta muestra?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de borrar este trabajo de tu portafolio. Ya no se mostrará a los clientes.
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
