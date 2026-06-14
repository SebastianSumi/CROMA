<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\Audiovisual;
use Flux\Flux;

class AudiovisualMain extends Component
{
    use WithPagination;

    public $search = '';

    public $registro_id;

    #[Validate(['required', 'integer', 'exists:detalle_pedido,id_detalle'])]
    public $id_detalle;

    #[Validate(['required', 'string', 'min:2', 'max:30'])]
    public $tipo;

    #[Validate(['nullable', 'integer', 'min:0'])]
    public $duracion_segundos;

    #[Validate(['nullable', 'url', 'max:255'])]
    public $archivo_fuente;

    #[Validate(['nullable', 'string', 'max:50'])]
    public $formato_salida;

    public function render()
    {
        $audiovisuales = Audiovisual::where('tipo', 'LIKE', '%' . $this->search . '%')
            ->latest('id_edicion')
            ->paginate(10);

        return view('livewire.audiovisual-main', compact('audiovisuales'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function crear()
    {
        $this->reset(['registro_id', 'id_detalle', 'tipo', 'duracion_segundos', 'archivo_fuente', 'formato_salida']);
        $this->modal('modal-audiovisual')->show();
    }

    public function guardar()
    {
        $this->validate();

        if (!$this->registro_id) {
            Audiovisual::create([
                'id_edicion'        => rand(10000, 99999),
                'id_detalle'        => $this->id_detalle,
                'tipo'              => $this->tipo,
                'duracion_segundos' => $this->duracion_segundos ?: null,
                'archivo_fuente'    => $this->archivo_fuente ?: null,
                'formato_salida'    => $this->formato_salida ?: null,
            ]);

            Flux::toast(
                heading: 'Proyecto Creado',
                text: 'La especificación audiovisual se guardó correctamente.',
                variant: 'success'
            );
        } else {
            $audio = Audiovisual::findOrFail($this->registro_id);
            $audio->update([
                'id_detalle'        => $this->id_detalle,
                'tipo'              => $this->tipo,
                'duracion_segundos' => $this->duracion_segundos ?: null,
                'archivo_fuente'    => $this->archivo_fuente ?: null,
                'formato_salida'    => $this->formato_salida ?: null,
            ]);

            Flux::toast(
                heading: 'Proyecto Actualizado',
                text: 'Los cambios en la edición se aplicaron correctamente.',
                variant: 'success'
            );
        }

        $this->modal('modal-audiovisual')->close();
    }

    public function editar(Audiovisual $item)
    {
        $this->registro_id       = $item->id_edicion;
        $this->id_detalle        = $item->id_detalle;
        $this->tipo              = $item->tipo;
        $this->duracion_segundos = $item->duracion_segundos;
        $this->archivo_fuente    = $item->archivo_fuente;
        $this->formato_salida    = $item->formato_salida;

        $this->modal('modal-audiovisual')->show();
    }

    public function confirmar(Audiovisual $item)
    {
        $this->registro_id = $item->id_edicion;
        $this->modal('modal-eliminar')->show();
    }

    public function eliminar()
    {
        $audio = Audiovisual::findOrFail($this->registro_id);
        $audio->delete();

        Flux::toast(
            heading: 'Registro Eliminado',
            text: 'El proyecto audiovisual fue removido del sistema.',
            variant: 'success'
        );

        $this->modal('modal-eliminar')->close();
    }
}
