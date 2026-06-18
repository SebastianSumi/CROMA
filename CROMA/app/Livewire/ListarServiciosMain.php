<?php

namespace App\Livewire;

use Livewire\Component;

class ListarServiciosMain extends Component
{
    /**
     * Redirige a la vista específica del servicio seleccionado.
     * Asegúrate de tener estas rutas definidas en tu web.php
     */
    public function irAModulo($ruta)
    {
        return $this->redirect('/' . $ruta, navigate: true);
    }

    public function render()
    {
        // Definimos los módulos del sistema (tus tablas de especialización)
        $modulos = [
            [
                'ruta' => 'impresion',
                'nombre' => 'Impresión Digital',
                'descripcion' => 'Gestión de afiches, trípticos, flyers y documentos en alta calidad.',
                'color' => 'blue'
            ],
            [
                'ruta' => 'offset',
                'nombre' => 'Impresión Offset',
                'descripcion' => 'Producción industrial masiva, folcotes, libros y revistas con acabados.',
                'color' => 'cyan'
            ],
            [
                'ruta' => 'diseno',
                'nombre' => 'Diseño Gráfico',
                'descripcion' => 'Control de logotipos, identidades visuales y revisión de editables.',
                'color' => 'fuchsia'
            ],
            [
                'ruta' => 'audiovisual',
                'nombre' => 'Edición Audiovisual',
                'descripcion' => 'Proyectos de video, spots publicitarios y recursos multimedia.',
                'color' => 'purple'
            ],
            [
                'ruta' => 'lanyard',
                'nombre' => 'Cintas y Lanyards',
                'descripcion' => 'Configuración de impresión de cintas personalizadas para eventos.',
                'color' => 'rose'
            ],
            [
                'ruta' => 'fotocheck',
                'nombre' => 'Fotochecks PVC',
                'descripcion' => 'Tarjetas de identificación corporativas, códigos e instituciones.',
                'color' => 'emerald'
            ],
        ];

        return view('livewire.listar-servicios-main', compact('modulos'));
    }
}
