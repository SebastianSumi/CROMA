<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Impresión Digital</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por documento..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Nueva Orden</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column>DOCUMENTO</flux:table.column>
            <flux:table.column>ESPECIFICACIONES</flux:table.column>
            <flux:table.column>DISEÑO</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($impresiones as $item)
                <flux:table.row>
                    <flux:table.cell class="font-bold">{{ $item->id_impresion }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $item->tipo_documento }}</flux:table.cell>
                    <flux:table.cell>
                        <span class="block text-sm text-gray-500">Papel: {{ $item->tipo_papel }}</span>
                        <span class="block text-sm text-gray-500">Tinta: {{ $item->tipo_tinta }}</span>
                        <span class="block text-sm text-gray-500">Formato: {{ $item->formato ?? 'N/A' }}</span>
                    </flux:table.cell>
                    <flux:table.cell>
                        <a href="{{ $item->diseno_url }}" target="_blank" class="text-violet-600 hover:underline">Ver Archivo</a>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_impresion }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_impresion }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $impresiones->links() }}
    </div>

    <flux:modal name="modal-impresion" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Orden' : 'Registrar Impresión' }}</flux:heading>
            </div>

            <flux:input wire:model="id_detalle" type="number" label="ID Detalle Pedido" placeholder="Ej: 45" />

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="tipo_documento" label="Tipo de Documento" placeholder="Ej: Afiche, Tríptico" />
                <flux:input wire:model="formato" label="Formato" placeholder="Ej: A4, A3" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="tipo_papel" label="Tipo de Papel" placeholder="Ej: Couché 150g" />
                <flux:input wire:model="tipo_tinta" label="Tipo de Tinta" placeholder="Ej: Full Color" />
            </div>

            <flux:input wire:model="diseno_url" type="url" label="URL del Diseño" placeholder="https://drive.google.com/..." />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar' : 'Guardar' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar registro?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar esta orden de impresión.<br>
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
