<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Pago;

class PagoMain extends Component
{
    // Propiedades del formulario
    #[Validate(['required', 'integer', 'exists:pedido,id_pedido'])]
    public $id_pedido;

    #[Validate(['required', 'numeric', 'min:0.01'])]
    public $monto;

    #[Validate(['required', 'date'])]
    public $fecha_pago;

    // Estado del CRUD
    public $idSeleccionado;
    public $estaEditando = false;

    /**
     * CREAR
     */
    public function guardar()
    {
        $this->validate();

        Pago::create([
            'id_pago'   => rand(10000, 99999),
            'id_pedido' => $this->id_pedido,
            'monto'     => $this->monto,
            'fecha_pago'=> $this->fecha_pago,
        ]);

        $this->limpiarFormulario();
        session()->flash('success', 'Pago registrado con éxito.');
    }

    /**
     * LEER PARA EDITAR
     */
    public function editar($id)
    {
        $pago = Pago::findOrFail($id);

        $this->idSeleccionado = $pago->id_pago;
        $this->id_pedido = $pago->id_pedido;
        $this->monto = $pago->monto;
        $this->fecha_pago = $pago->fecha_pago->format('Y-m-d');

        $this->estaEditando = true;
    }

    /**
     * ACTUALIZAR
     */
    public function actualizar()
    {
        $this->validate();

        $pago = Pago::findOrFail($this->idSeleccionado);
        $pago->update([
            'id_pedido' => $this->id_pedido,
            'monto'     => $this->monto,
            'fecha_pago'=> $this->fecha_pago,
        ]);

        $this->limpiarFormulario();
        session()->flash('success', 'Pago actualizado con éxito.');
    }

    /**
     * ELIMINAR
     */
    public function eliminar($id)
    {
        Pago::findOrFail($id)->delete();
        session()->flash('success', 'Pago eliminado del sistema.');
    }

    public function limpiarFormulario()
    {
        $this->reset(['id_pedido', 'monto', 'fecha_pago', 'idSeleccionado', 'estaEditando']);
    }

    public function render()
    {
        return view('livewire.pago-main', [
            'pagos' => Pago::with('pedido')->get()
        ]);
    }
}
