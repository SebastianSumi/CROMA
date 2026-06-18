<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\WithPagination;

class ProductMain extends Component
{
    use WithPagination;

    // Propiedades para búsquedas y filtros
    public $search = '';

    // Propiedades del formulario
    public $registro_id; // Equivale a tu $registro_id anterior para saber si es edición o creación
    public $nombre;
    public $descripcion;
    public $precio_base;
    public $imagen_url;
    public $activo = 1;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Producto::query();

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        }

        return view('livewire.product-main', [
            'productos' => $query->orderBy('id_producto', 'desc')->paginate(10)
        ]);
    }

    // Inicializar formulario para nueva inserción
    public function crear()
    {
        $this->limpiarFormulario();
        $this->modal('modal-producto')->show();
    }

    // Cargar datos para edición
    public function editar($id)
    {
        $this->limpiarFormulario();
        $producto = Producto::findOrFail($id);

        $this->registro_id = $producto->id_producto;
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->precio_base = $producto->precio_base;
        $this->imagen_url = $producto->imagen_url;
        $this->activo = $producto->activo;

        $this->modal('modal-producto')->show();
    }

    // Guardar o actualizar registro
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|min:3|max:100',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|url',
            'activo' => 'required|in:0,1',
        ]);

        Producto::updateOrCreate(
            ['id_producto' => $this->registro_id],
            [
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio_base' => $this->precio_base,
                'imagen_url' => $this->imagen_url,
                'activo' => $this->activo,
            ]
        );

        $this->modal('modal-producto')->close();
        $this->limpiarFormulario();
    }

    // Activar confirmación de borrado
    public function confirmar($id)
    {
        $this->registro_id = $id;
        $this->modal('modal-eliminar')->show();
    }

    // Ejecutar el borrado físico
    public function eliminar()
    {
        if ($this->registro_id) {
            Producto::findOrFail($this->registro_id)->delete();
            $this->modal('modal-eliminar')->close();
            $this->limpiarFormulario();
        }
    }

    private function limpiarFormulario()
    {
        $this->registro_id = null;
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio_base = '';
        $this->imagen_url = '';
        $this->activo = 1;
    }
}
