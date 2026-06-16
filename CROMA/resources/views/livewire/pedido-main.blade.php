<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Pedidos</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por ID cliente o estado..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Nuevo Pedido</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>N° PEDIDO</flux:table.column>
            <flux:table.column>CLIENTE (ID)</flux:table.column>
            <flux:table.column>FECHA</flux:table.column>
            <flux:table.column>ESTADO</flux:table.column>
            <flux:table.column>TOTAL</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($pedidos as $item)
                <flux:table.row>
                    <flux:table.cell class="font-bold">#{{ $item->id_pedido }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:badge size="sm" color="zinc">ID: {{ $item->id_cliente }}</flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</flux:table.cell>

                    <flux:table.cell>
                        @php
                            $colorEstado = match($item->estado) {
                                'Entregado' => 'green',
                                'En Producción' => 'orange',
                                'Anulado' => 'red',
                                default => 'blue',
                            };
                        @endphp
                        <flux:badge size="sm" color="{{ $colorEstado }}">{{ $item->estado }}</flux:badge>
                    </flux:table.cell>

                    <flux:table.cell variant="strong" class="text-right text-green-600">
                        S/. {{ number_format($item->total, 2) }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_pedido }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_pedido }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $pedidos->links() }}
    </div>

    <flux:modal name="modal-pedido" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Pedido' : 'Registrar Pedido' }}</flux:heading>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="id_cliente" type="number" label="ID del Cliente" placeholder="Ej: 15" />
                <flux:input wire:model="fecha" type="date" label="Fecha de Recepción" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="estado" label="Estado" placeholder="Pendiente, Entregado, Anulado..." />
                <flux:input wire:model="total" type="number" step="0.01" label="Total (S/.)" placeholder="0.00" />
            </div>

            <flux:textarea wire:model="observaciones" label="Observaciones" placeholder="Indicaciones de entrega, prioridades, etc." />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Pedido' : 'Guardar Pedido' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar pedido?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar este pedido del sistema.<br>
                    Esta acción es irreversible y podría afectar el historial financiero del cliente.
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
