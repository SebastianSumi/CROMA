<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\Impresion;
use Flux\Flux;

class ImpresionMain extends Component
{
    use WithPagination;

    public $search = '';


    public $registro_id;

    #[Validate(['required', 'integer', 'exists:detalle_pedido,id_detalle'])]
    public $id_detalle;

    #[Validate(['required', 'string', 'max:30'])]
    public $tipo_documento;

    #[Validate(['required', 'string', 'max:30'])]
    public $tipo_papel;

    #[Validate(['required', 'string', 'max:30'])]
    public $tipo_tinta;

    #[Validate(['nullable', 'string', 'max:20'])]
    public $formato;

    #[Validate(['required', 'url', 'max:255'])]
    public $diseno_url;

    public function render()
    {
        $impresiones = Impresion::where('tipo_documento', 'LIKE', '%' . $this->search . '%')
            ->latest('id_impresion')
            ->paginate(10);

        return view('livewire.impresion-main', compact('impresiones'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function crear()
    {
        $this->reset(['registro_id', 'id_detalle', 'tipo_documento', 'tipo_papel', 'tipo_tinta', 'formato', 'diseno_url']);
        $this->modal('modal-impresion')->show();
    }

    public function guardar()
    {
        $this->validate();

        if (!$this->registro_id) {

            Impresion::create([
                'id_impresion'   => rand(10000, 99999), // Solo porque tu ID no es autoincremental
                'id_detalle'     => $this->id_detalle,
                'tipo_documento' => $this->tipo_documento,
                'tipo_papel'     => $this->tipo_papel,
                'tipo_tinta'     => $this->tipo_tinta,
                'formato'        => $this->formato ?: null,
                'diseno_url'     => $this->diseno_url,
            ]);

            Flux::toast(
                heading: 'Orden Registrada',
                text: 'La configuración de impresión se guardó correctamente.',
                variant: 'success'
            );
        } else {

            $imp = Impresion::findOrFail($this->registro_id);
            $imp->update([
                'id_detalle'     => $this->id_detalle,
                'tipo_documento' => $this->tipo_documento,
                'tipo_papel'     => $this->tipo_papel,
                'tipo_tinta'     => $this->tipo_tinta,
                'formato'        => $this->formato ?: null,
                'diseno_url'     => $this->diseno_url,
            ]);

            Flux::toast(
                heading: 'Orden Actualizada',
                text: 'Los cambios se aplicaron correctamente.',
                variant: 'success'
            );
        }

        $this->modal('modal-impresion')->close();
    }

    public function editar(Impresion $item)
    {
        $this->registro_id    = $item->id_impresion;
        $this->id_detalle     = $item->id_detalle;
        $this->tipo_documento = $item->tipo_documento;
        $this->tipo_papel     = $item->tipo_papel;
        $this->tipo_tinta     = $item->tipo_tinta;
        $this->formato        = $item->formato;
        $this->diseno_url     = $item->diseno_url;

        $this->modal('modal-impresion')->show();
    }

    public function confirmar(Impresion $item)
    {
        $this->registro_id = $item->id_impresion;
        $this->modal('modal-eliminar')->show();
    }

    public function eliminar()
    {
        $imp = Impresion::findOrFail($this->registro_id);
        $imp->delete();

        Flux::toast(
            heading: 'Registro Eliminado',
            text: 'La orden de impresión fue removida del sistema.',
            variant: 'success'
        );

        $this->modal('modal-eliminar')->close();
    }
}
