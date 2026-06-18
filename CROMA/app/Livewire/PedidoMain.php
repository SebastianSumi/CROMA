<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\Pedido;
use Flux\Flux;
use Carbon\Carbon;

class PedidoMain extends Component
{
    use WithPagination;

    public $search = '';


    public $registro_id;
    public $estaEditando = false;

    #[Validate(['required', 'integer', 'exists:cliente,id_cliente'])]
    public $id_cliente;

    #[Validate(['required', 'date'])]
    public $fecha;

    #[Validate(['required', 'string', 'max:20'])]
    public $estado; // Ej: 'Pendiente', 'En Producción', 'Entregado'

    #[Validate(['nullable', 'numeric', 'min:0'])]
    public $total;

    #[Validate(['nullable', 'string'])]
    public $observaciones;


    public function render()
    {

        $pedidos = Pedido::where('id_cliente', 'LIKE', '%' . $this->search . '%')
            ->orWhere('estado', 'LIKE', '%' . $this->search . '%')
            ->latest('fecha_registro')
            ->paginate(10);

        return view('livewire.pedido-main', compact('pedidos'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }


    public function crear()
    {
        $this->limpiarFormulario();

        // Valores por defecto al crear
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->estado = 'Pendiente';
        $this->total = 0.00;

        $this->modal('modal-pedido')->show();
    }


    public function guardar()
    {
        $this->validate();

        if (!$this->estaEditando) {
            // Lógica de Creación
            Pedido::create([
                'id_pedido'      => rand(10000, 99999), // Asignación manual requerida por tu esquema
                'id_cliente'     => $this->id_cliente,
                'fecha'          => $this->fecha,
                'estado'         => $this->estado,
                'total'          => $this->total ?: 0.00,
                'observaciones'  => $this->observaciones ?: null,
            ]);

            Flux::toast(
                heading: 'Pedido Registrado',
                text: 'El nuevo pedido se generó correctamente.',
                variant: 'success'
            );
        } else {

            $pedido = Pedido::findOrFail($this->registro_id);
            $pedido->update([
                'id_cliente'    => $this->id_cliente,
                'fecha'         => $this->fecha,
                'estado'        => $this->estado,
                'total'         => $this->total ?: 0.00,
                'observaciones' => $this->observaciones ?: null,
            ]);

            Flux::toast(
                heading: 'Pedido Actualizado',
                text: 'Los detalles del pedido fueron modificados.',
                variant: 'success'
            );
        }

        $this->modal('modal-pedido')->close();
    }

    public function editar(Pedido $item)
    {
        $this->registro_id   = $item->id_pedido;
        $this->id_cliente    = $item->id_cliente;
        $this->fecha         = Carbon::parse($item->fecha)->format('Y-m-d');
        $this->estado        = $item->estado;
        $this->total         = $item->total;
        $this->observaciones = $item->observaciones;

        $this->estaEditando = true;
        $this->modal('modal-pedido')->show();
    }

    public function confirmar(Pedido $item)
    {
        $this->registro_id = $item->id_pedido;
        $this->modal('modal-eliminar')->show();
    }

    public function eliminar()
    {
        Pedido::findOrFail($this->registro_id)->delete();

        Flux::toast(
            heading: 'Pedido Eliminado',
            text: 'El registro se eliminó permanentemente del sistema.',
            variant: 'success'
        );

        $this->modal('modal-eliminar')->close();
    }

    /**
     * Restablece las propiedades del componente a su estado inicial
     */
    public function limpiarFormulario()
    {
        $this->reset([
            'registro_id',
            'id_cliente',
            'fecha',
            'estado',
            'total',
            'observaciones',
            'estaEditando'
        ]);
    }
}
