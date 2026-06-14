<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\Pago;
use Flux\Flux;
use Carbon\Carbon;

class PagoMain extends Component
{
    use WithPagination;


    public $search = '';

    public $registro_id;

    #[Validate(['required', 'integer', 'exists:pedido,id_pedido'])]
    public $id_pedido;

    #[Validate(['required', 'numeric', 'min:0.01'])]
    public $monto;

    #[Validate(['required', 'date'])]
    public $fecha_pago;

    public function render()
    {

        $pagos = Pago::where('id_pedido', 'LIKE', '%' . $this->search . '%')
            ->latest('id_pago')
            ->paginate(10);

        return view('livewire.pago-main', compact('pagos'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function crear()
    {
        $this->reset(['registro_id', 'id_pedido', 'monto', 'fecha_pago']);

        $this->fecha_pago = Carbon::now()->format('Y-m-d\TH:i');

        $this->modal('modal-pago')->show();
    }

    public function guardar()
    {
        $this->validate();

        if (!$this->registro_id) {
            Pago::create([
                'id_pago'    => rand(10000, 99999),
                'id_pedido'  => $this->id_pedido,
                'monto'      => $this->monto,
                'fecha_pago' => $this->fecha_pago,
            ]);

            Flux::toast(
                heading: 'Pago Registrado',
                text: 'El ingreso de dinero se guardó correctamente.',
                variant: 'success'
            );
        } else {
            $pago = Pago::findOrFail($this->registro_id);
            $pago->update([
                'id_pedido'  => $this->id_pedido,
                'monto'      => $this->monto,
                'fecha_pago' => $this->fecha_pago,
            ]);

            Flux::toast(
                heading: 'Pago Actualizado',
                text: 'Los datos financieros se modificaron correctamente.',
                variant: 'success'
            );
        }

        $this->modal('modal-pago')->close();
    }

    public function editar(Pago $item)
    {
        $this->registro_id = $item->id_pago;
        $this->id_pedido   = $item->id_pedido;
        $this->monto       = $item->monto;

        $this->fecha_pago  = Carbon::parse($item->fecha_pago)->format('Y-m-d\TH:i');

        $this->modal('modal-pago')->show();
    }

    public function confirmar(Pago $item)
    {
        $this->registro_id = $item->id_pago;
        $this->modal('modal-eliminar')->show();
    }

    public function eliminar()
    {
        $pago = Pago::findOrFail($this->registro_id);
        $pago->delete();

        Flux::toast(
            heading: 'Pago Eliminado',
            text: 'El registro financiero fue removido del sistema.',
            variant: 'success'
        );

        $this->modal('modal-eliminar')->close();
    }
}
