<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Pagos</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por N° Pedido..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Registrar Pago</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>N° RECIBO</flux:table.column>
            <flux:table.column>N° PEDIDO</flux:table.column>
            <flux:table.column>FECHA Y HORA</flux:table.column>
            <flux:table.column>MONTO</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($pagos as $item)
                <flux:table.row>
                    <flux:table.cell class="font-bold text-gray-500">#{{ $item->id_pago }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:badge size="sm" color="blue">Pedido #{{ $item->id_pedido }}</flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ \Carbon\Carbon::parse($item->fecha_pago)->format('d/m/Y - h:i A') }}
                    </flux:table.cell>

                    <flux:table.cell variant="strong" class="text-right text-green-600">
                        S/. {{ number_format($item->monto, 2) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_pago }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_pago }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $pagos->links() }}
    </div>

    <flux:modal name="modal-pago" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Pago' : 'Registrar Nuevo Pago' }}</flux:heading>
            </div>

            <flux:input wire:model="id_pedido" type="number" label="ID del Pedido" placeholder="Ej: 105" />

            <flux:input wire:model="monto" type="number" step="0.01" label="Monto Abonado (S/.)" placeholder="0.00" />

            <flux:input wire:model="fecha_pago" type="datetime-local" label="Fecha y Hora de Transacción" />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Pago' : 'Guardar Pago' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Anular transacción?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar este registro de pago de la base de datos.<br>
                    Esta acción podría descuadrar la caja y no se puede deshacer.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button wire:click="eliminar()" type="submit" variant="danger">Sí, anular pago</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
