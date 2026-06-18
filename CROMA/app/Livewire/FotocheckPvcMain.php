<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\FotocheckPvc;
use Flux\Flux;

class FotocheckPvcMain extends Component
{
    use WithPagination;

    public $search = '';
    public $registro_id;
    public $estaEditando = false;

    #[Validate(['required', 'integer', 'exists:detalle_pedido,id_detalle'])]
    public $id_detalle;

    #[Validate(['nullable', 'string', 'max:200'])]
    public $nombre_titular;

    #[Validate(['nullable', 'string', 'max:100'])]
    public $cargo;

    #[Validate(['nullable', 'url', 'max:255'])]
    public $foto_url;

    #[Validate(['nullable', 'string', 'max:150'])]
    public $institucion;

    #[Validate(['nullable', 'string', 'max:50'])]
    public $codigo_trabajador;

    public function render()
    {
        $fotochecks = FotocheckPvc::where('nombre_titular', 'LIKE', '%' . $this->search . '%')
            ->orWhere('codigo_trabajador', 'LIKE', '%' . $this->search . '%')
            ->latest('id_fotocheck')
            ->paginate(10);

        return view('livewire.fotocheck-pvc-main', compact('fotochecks'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function crear()
    {
        $this->limpiarFormulario();
        $this->modal('modal-fotocheck')->show();
    }

    public function guardar()
    {
        $this->validate();

        if (!$this->estaEditando) {
            FotocheckPvc::create([
                'id_fotocheck'      => rand(10000, 99999),
                'id_detalle'        => $this->id_detalle,
                'nombre_titular'    => $this->nombre_titular ?: null,
                'cargo'             => $this->cargo ?: null,
                'foto_url'          => $this->foto_url ?: null,
                'institucion'       => $this->institucion ?: null,
                'codigo_trabajador' => $this->codigo_trabajador ?: null,
            ]);

            Flux::toast(heading: 'Fotocheck Registrado', text: 'Se guardó correctamente.', variant: 'success');
        } else {
            $foto = FotocheckPvc::findOrFail($this->registro_id);
            $foto->update([
                'id_detalle'        => $this->id_detalle,
                'nombre_titular'    => $this->nombre_titular ?: null,
                'cargo'             => $this->cargo ?: null,
                'foto_url'          => $this->foto_url ?: null,
                'institucion'       => $this->institucion ?: null,
                'codigo_trabajador' => $this->codigo_trabajador ?: null,
            ]);

            Flux::toast(heading: 'Fotocheck Actualizado', text: 'Modificación exitosa.', variant: 'success');
        }

        $this->modal('modal-fotocheck')->close();
    }

    public function editar(FotocheckPvc $item)
    {
        $this->registro_id       = $item->id_fotocheck;
        $this->id_detalle        = $item->id_detalle;
        $this->nombre_titular    = $item->nombre_titular;
        $this->cargo             = $item->cargo;
        $this->foto_url          = $item->foto_url;
        $this->institucion       = $item->institucion;
        $this->codigo_trabajador = $item->codigo_trabajador;

        $this->estaEditando = true;
        $this->modal('modal-fotocheck')->show();
    }

    public function confirmar(FotocheckPvc $item)
    {
        $this->registro_id = $item->id_fotocheck;
        $this->modal('modal-eliminar')->show();
    }

    public function eliminar()
    {
        FotocheckPvc::findOrFail($this->registro_id)->delete();

        Flux::toast(heading: 'Registro Eliminado', text: 'El registro fue borrado.', variant: 'success');
        $this->modal('modal-eliminar')->close();
    }

    public function limpiarFormulario()
    {
        $this->reset(['registro_id', 'id_detalle', 'nombre_titular', 'cargo', 'foto_url', 'institucion', 'codigo_trabajador', 'estaEditando']);
    }
}
