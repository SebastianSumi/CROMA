<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TrabajoAnterior;
use App\Models\Producto; // Para cargar el select de categorías
use Livewire\WithPagination;

class TrabajoAnteriorMain extends Component
{
    use WithPagination;

    public $search = '';

    // Propiedades del formulario
    public $registro_id;
    public $titulo;
    public $descripcion;
    public $imagen_url;
    public $producto_id;
    public $fecha_realizacion;
    public $activo = 1;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = TrabajoAnterior::with('producto');

        if ($this->search) {
            $query->where('titulo', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        }

        return view('livewire.trabajo-anterior-main', [
            'trabajos' => $query->orderBy('id_trabajo', 'desc')->paginate(10),
            'productos_disponibles' => Producto::where('activo', 1)->get() // Para el select del formulario
        ]);
    }

    public function crear()
    {
        $this->limpiarFormulario();
        $this->modal('modal-trabajo')->show();
    }

    public function editar($id)
    {
        $this->limpiarFormulario();
        $trabajo = TrabajoAnterior::findOrFail($id);

        $this->registro_id = $trabajo->id_trabajo;
        $this->titulo = $trabajo->titulo;
        $this->descripcion = $trabajo->descripcion;
        $this->imagen_url = $trabajo->imagen_url;
        $this->producto_id = $trabajo->producto_id;
        $this->fecha_realizacion = $trabajo->fecha_realizacion;
        $this->activo = $trabajo->activo;

        $this->modal('modal-trabajo')->show();
    }

    public function guardar()
    {
        $this->validate([
            'titulo' => 'required|min:3|max:150',
            'descripcion' => 'nullable|string',
            'imagen_url' => 'required|url',
            'producto_id' => 'nullable|exists:productos,id_producto',
            'fecha_realizacion' => 'nullable|date',
            'activo' => 'required|in:0,1',
        ]);

        TrabajoAnterior::updateOrCreate(
            ['id_trabajo' => $this->registro_id],
            [
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'imagen_url' => $this->imagen_url,
                'producto_id' => $this->producto_id,
                'fecha_realizacion' => $this->fecha_realizacion,
                'activo' => $this->activo,
            ]
        );

        $this->modal('modal-trabajo')->close();
        $this->limpiarFormulario();
    }

    public function confirmar($id)
    {
        $this->registro_id = $id;
        $this->modal('modal-eliminar')->show();
    }

    public function eliminar()
    {
        if ($this->registro_id) {
            TrabajoAnterior::findOrFail($this->registro_id)->delete();
            $this->modal('modal-eliminar')->close();
            $this->limpiarFormulario();
        }
    }

    private function limpiarFormulario()
    {
        $this->registro_id = null;
        $this->titulo = '';
        $this->descripcion = '';
        $this->imagen_url = '';
        $this->producto_id = null;
        $this->fecha_realizacion = '';
        $this->activo = 1;
    }
}
