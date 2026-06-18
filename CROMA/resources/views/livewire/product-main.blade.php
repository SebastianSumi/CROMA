<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-indigo-500">Gestión de Catálogo de Productos</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por nombre de producto (Ej: Volantes, Carpetas)..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="indigo" icon="plus">Nuevo Producto</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>CÓDIGO</flux:table.column>
            <flux:table.column>PRODUCTO Y DESCRIPCIÓN</flux:table.column>
            <flux:table.column>PRECIO BASE</flux:table.column>
            <flux:table.column>ESTADO</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($productos as $item)
                <flux:table.row>
                    <flux:table.cell>
                        <span class="font-bold text-gray-700">#{{ $item->id_producto }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-3">
                            @if($item->imagen_url)
                                <img src="{{ $item->imagen_url }}" alt="{{ $item->nombre }}" class="w-10 h-10 object-cover rounded-md border border-gray-200">
                            @else
                                <div class="w-10 h-10 bg-gray-100 flex items-center justify-center rounded-md border text-gray-400">
                                    📦
                                </div>
                            @endif
                            <div>
                                <span class="block font-semibold text-gray-800">{{ $item->nombre }}</span>
                                <span class="block text-xs text-gray-500 max-w-sm truncate">{{ $item->descripcion ?? 'Sin descripción disponible.' }}</span>
                            </div>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="font-bold text-gray-900">S/. {{ number_format($item->precio_base, 2) }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if($item->activo)
                            <flux:badge size="sm" color="green" inset>Visible</flux:badge>
                        @else
                            <flux:badge size="sm" color="red" inset>Oculto</flux:badge>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_producto }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_producto }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $productos->links() }}
    </div>

    <flux:modal name="modal-producto" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Producto del Catálogo' : 'Agregar Nuevo Producto' }}</flux:heading>
            </div>

            <flux:input wire:model="nombre" label="Nombre del Producto" placeholder="Ej: Tarjetas de Presentación, Volantes A5" />

            <flux:textarea wire:model="descripcion" label="Descripción Comercial (Para clientes)" placeholder="Ej: Impresión en papel couché de 300gr con acabado mate..." rows="3" />

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="precio_base" type="number" step="0.01" label="Precio Base (S/.)" placeholder="0.00" icon="currency-dollar" />

                <flux:select wire:model="activo" label="Visibilidad en Catálogo">
                    <option value="1">Mostrar al público</option>
                    <option value="0">Ocultar provisionalmente</option>
                </flux:select>
            </div>

            <flux:input wire:model="imagen_url" type="url" label="URL de la Imagen de Portada" placeholder="Enlace a la imagen del catálogo o muestra referencial..." />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="indigo" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Producto' : 'Guardar Producto' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Dar de baja este producto?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar este producto del catálogo comercial.<br>
                    Los clientes ya no podrán seleccionarlo ni ver sus precios de forma pública.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button wire:click="eliminar()" type="submit" variant="danger">Sí, eliminar producto</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
