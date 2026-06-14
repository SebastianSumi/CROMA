<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\Offset;
use Flux\Flux;

class OffsetMain extends Component
{
    use WithPagination;


    public $search = '';

    public $registro_id;

    #[Validate(['required', 'integer', 'exists:detalle_pedido,id_detalle'])]
    public $id_detalle;

    #[Validate(['required', 'string', 'max:30'])]
    public $tipo_material;

    #[Validate(['nullable', 'integer', 'min:1'])]
    public $num_paginas;

    #[Validate(['nullable', 'string', 'max:100'])]
    public $acabado;

    #[Validate(['required', 'url', 'max:255'])]
    public $diseno_url;

    public function render()
    {
        $offsets = Offset::where('tipo_material', 'LIKE', '%' . $this->search . '%')
            ->latest('id_offset')
            ->paginate(10);

        return view('livewire.offset-main', compact('offsets'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function crear()
    {
        $this->reset(['registro_id', 'id_detalle', 'tipo_material', 'num_paginas', 'acabado', 'diseno_url']);
        $this->modal('modal-offset')->show();
    }

    public function guardar()
    {
        $this->validate();

        if (!$this->registro_id) {
            Offset::create([
                'id_offset'     => rand(10000, 99999),
                'id_detalle'    => $this->id_detalle,
                'tipo_material' => $this->tipo_material,
                'num_paginas'   => $this->num_paginas ?: null,
                'acabado'       => $this->acabado ?: null,
                'diseno_url'    => $this->diseno_url,
            ]);

            Flux::toast(
                heading: 'Servicio Registrado',
                text: 'La configuración de offset se guardó correctamente.',
                variant: 'success'
            );
        } else {
            $off = Offset::findOrFail($this->registro_id);
            $off->update([
                'id_detalle'    => $this->id_detalle,
                'tipo_material' => $this->tipo_material,
                'num_paginas'   => $this->num_paginas ?: null,
                'acabado'       => $this->acabado ?: null,
                'diseno_url'    => $this->diseno_url,
            ]);

            Flux::toast(
                heading: 'Servicio Actualizado',
                text: 'Los cambios en la configuración offset se aplicaron.',
                variant: 'success'
            );
        }

        $this->modal('modal-offset')->close();
    }

    public function editar(Offset $item)
    {
        $this->registro_id   = $item->id_offset;
        $this->id_detalle    = $item->id_detalle;
        $this->tipo_material = $item->tipo_material;
        $this->num_paginas   = $item->num_paginas;
        $this->acabado       = $item->acabado;
        $this->diseno_url    = $item->diseno_url;

        $this->modal('modal-offset')->show();
    }

    public function confirmar(Offset $item)
    {
        $this->registro_id = $item->id_offset;
        $this->modal('modal-eliminar')->show();
    }

    public function eliminar()
    {
        $off = Offset::findOrFail($this->registro_id);
        $off->delete();

        Flux::toast(
            heading: 'Registro Eliminado',
            text: 'La orden de impresión offset fue removida del sistema.',
            variant: 'success'
        );

        $this->modal('modal-eliminar')->close();
    }
}
