<div>
    <h1 class="text-3xl mb-10 border-b-3 pb-1 border-violet-500">Gestión de Diseño Gráfico</h1>

    <div class="flex gap-2 mb-4">
        <flux:input wire:model.live="search" placeholder="Buscar por tipo o estado..." icon="magnifying-glass"/>
        <flux:button wire:click="crear()" variant="primary" color="violet" icon="plus">Nuevo Diseño</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>N° DISEÑO</flux:table.column>
            <flux:table.column>TIPO</flux:table.column>
            <flux:table.column>ESTADO</flux:table.column>
            <flux:table.column>ARCHIVOS</flux:table.column>
            <flux:table.column>OPCIONES</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($disenos as $item)
                <flux:table.row>
                    <flux:table.cell>
                        <span class="font-bold">#{{ $item->id_diseno }}</span>
                        <br>
                        <span class="text-xs text-gray-400">Detalle: {{ $item->id_detalle }}</span>
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">{{ $item->tipo }}</flux:table.cell>

                    <flux:table.cell>
                        @php
                            $colorEstado = match(strtolower($item->estado_aprobacion)) {
                                'aprobado' => 'green',
                                'en proceso' => 'orange',
                                'rechazado' => 'red',
                                default => 'blue',
                            };
                        @endphp
                        <flux:badge size="sm" color="{{ $colorEstado }}">{{ $item->estado_aprobacion }}</flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex flex-col gap-1">
                            @if($item->arch_fuente_url)
                                <a href="{{ $item->arch_fuente_url }}" target="_blank" class="text-xs text-violet-600 hover:underline">📁 Editable (Fuente)</a>
                            @else
                                <span class="text-xs text-gray-400">Sin editable</span>
                            @endif
                            <a href="{{ $item->arch_result_url }}" target="_blank" class="text-xs text-blue-600 hover:underline">✅ Resultado Final</a>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button wire:click="editar({{ $item->id_diseno }})" variant="primary" color="orange" size="sm">Editar</flux:button>
                        <flux:button wire:click="confirmar({{ $item->id_diseno }})" variant="primary" color="red" size="sm">Eliminar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $disenos->links() }}
    </div>

    <flux:modal name="modal-diseno" flyout>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $registro_id ? 'Editar Diseño' : 'Registrar Diseño' }}</flux:heading>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="id_detalle" type="number" label="ID Detalle Pedido" placeholder="Ej: 8" />
                <flux:input wire:model="estado_aprobacion" label="Estado de Aprobación" placeholder="En proceso, Aprobado..." />
            </div>

            <flux:input wire:model="tipo" label="Tipo de Diseño" placeholder="Ej: Identidad Visual, Flyer publicitario" />

            <flux:input wire:model="arch_fuente_url" type="url" label="URL Archivo Fuente (Editable)" placeholder="Enlace a Illustrator, Photoshop..." />

            <flux:input wire:model="arch_result_url" type="url" label="URL Resultado Final (Exportado)" placeholder="Enlace al PDF, PNG, JPG..." />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="guardar()" variant="primary" color="violet" icon="arrow-turn-down-right">
                    {{ $registro_id ? 'Actualizar Diseño' : 'Guardar Diseño' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="modal-eliminar" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar registro?</flux:heading>
                <flux:text class="mt-2">
                    Estás a punto de eliminar este flujo de diseño.<br>
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
