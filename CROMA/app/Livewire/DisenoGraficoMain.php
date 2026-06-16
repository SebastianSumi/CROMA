<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\DisenoGrafico;
use Flux\Flux;

class DisenoGraficoMain extends Component
{
    use WithPagination;

    // Buscador interactivo
    public $search = '';

    // Estados del CRUD
    public $registro_id;
    public $estaEditando = false;

    #[Validate(['required', 'integer', 'exists:detalle_pedido,id_detalle'])]
    public $id_detalle;

    #[Validate(['required', 'string', 'max:30'])]
    public $tipo;
    #[Validate(['nullable', 'url', 'max:255'])]
    public $arch_fuente_url;

    #[Validate(['required', 'string', 'max:20'])]
    public $estado_aprobacion;
    #[Validate(['required', 'url', 'max:255'])]
    public $arch_result_url; // Enlace al exportado final (.pdf, .png) - Obligatorio

    public function render()
    {

        $disenos = DisenoGrafico::where('tipo', 'LIKE', '%' . $this->search . '%')
            ->orWhere('estado_aprobacion', 'LIKE', '%' . $this->search . '%')
            ->latest('id_diseno')
            ->paginate(10);

        return view('livewire.diseno-grafico-main', compact('disenos'));
    }


    public function updatingSearch(): void
    {
        $this->resetPage();
    }


    public function crear()
    {
        $this->limpiarFormulario();

        $this->estado_aprobacion = 'En proceso';

        $this->modal('modal-diseno')->show();
    }

    public function guardar()
    {
        $this->validate();

        if (!$this->estaEditando) {

            DisenoGrafico::create([
                'id_diseno'         => rand(10000, 99999), // Asignación manual
                'id_detalle'        => $this->id_detalle,
                'tipo'              => $this->tipo,
                'arch_fuente_url'   => $this->arch_fuente_url ?: null,
                'estado_aprobacion' => $this->estado_aprobacion,
                'arch_result_url'   => $this->arch_result_url,
            ]);

            Flux::toast(
                heading: 'Diseño Registrado',
                text: 'El nuevo flujo de diseño gráfico se creó con éxito.',
                variant: 'success'
            );
        } else {
            $diseno = DisenoGrafico::findOrFail($this->registro_id);
            $diseno->update([
                'id_detalle'        => $this->id_detalle,
                'tipo'              => $this->tipo,
                'arch_fuente_url'   => $this->arch_fuente_url ?: null,
                'estado_aprobacion' => $this->estado_aprobacion,
                'arch_result_url'   => $this->arch_result_url,
            ]);

            Flux::toast(
                heading: 'Diseño Actualizado',
                text: 'El progreso del diseño fue modificado correctamente.',
                variant: 'success'
            );
        }

        $this->modal('modal-diseno')->close();
    }


    public function editar(DisenoGrafico $item)
    {
        $this->registro_id       = $item->id_diseno;
        $this->id_detalle        = $item->id_detalle;
        $this->tipo              = $item->tipo;
        $this->arch_fuente_url   = $item->arch_fuente_url;
        $this->estado_aprobacion = $item->estado_aprobacion;
        $this->arch_result_url   = $item->arch_result_url;

        $this->estaEditando = true;
        $this->modal('modal-diseno')->show();
    }

    public function confirmar(DisenoGrafico $item)
    {
        $this->registro_id = $item->id_diseno;
        $this->modal('modal-eliminar')->show();
    }


    public function eliminar()
    {
        DisenoGrafico::findOrFail($this->registro_id)->delete();

        Flux::toast(
            heading: 'Registro Eliminado',
            text: 'El trabajo de diseño fue eliminado del historial.',
            variant: 'success'
        );

        $this->modal('modal-eliminar')->close();
    }

    public function limpiarFormulario()
    {
        $this->reset([
            'registro_id',
            'id_detalle',
            'tipo',
            'arch_fuente_url',
            'estado_aprobacion',
            'arch_result_url',
            'estaEditando'
        ]);
    }
}
