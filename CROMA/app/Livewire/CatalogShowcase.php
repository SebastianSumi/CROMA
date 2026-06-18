<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\TrabajoAnterior; // <-- IMPORTANTE: Importar el nuevo modelo

class CatalogShowcase extends Component
{
    public $view = 'catalog';
    public $search = '';

    public function changeView($targetView)
    {
        $this->view = $targetView;
    }

    public function render()
    {
        // 1. Productos para la pestaña del Catálogo (Lista de precios)
        $queryProductos = Producto::where('activo', 1);

        if ($this->search) {
            $queryProductos->where('nombre', 'like', '%' . $this->search . '%');
        }

        $productos = $queryProductos->orderBy('nombre', 'asc')->get();

        // 2. Trabajos Anteriores para la pestaña de Galería
        // Ahora jalamos directamente de la tabla trabajos_anteriores
        $queryMuestras = TrabajoAnterior::with('producto')->where('activo', 1);

        if ($this->search) {
            $queryMuestras->where(function($q) {
                $q->where('titulo', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });
        }

        $muestras = $queryMuestras->inRandomOrder()->get();

        return view('livewire.catalog-showcase', [
            'productos' => $productos,
            'muestras' => $muestras
        ]);
    }
}
