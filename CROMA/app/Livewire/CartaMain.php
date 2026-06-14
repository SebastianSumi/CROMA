<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Carta;

class CartaMain extends Component
{

    public $cartas;


    public $id_carta;

    public $num_paginas;
    public $tipo_material;
    public $diseno_url;
    public $incluye_fotos = false;


    public $editando = false;



    protected $rules = [
        'num_paginas' => 'nullable|integer',
        'tipo_material' => 'nullable|string|max:100',
        'diseno_url' => 'nullable|string|max:255',
        'incluye_fotos' => 'boolean',
    ];



    public function mount()
    {
        $this->listar();
    }



    public function listar()
    {
        $this->cartas = Carta::all();
    }



    public function guardar()
    {
        $this->validate();


        Carta::create([

            'num_paginas' => $this->num_paginas,

            'tipo_material' => $this->tipo_material,

            'diseno_url' => $this->diseno_url,

            'incluye_fotos' => $this->incluye_fotos,

        ]);


        $this->limpiar();

        $this->listar();
    }




    public function editar($id)
    {
        $carta = Carta::findOrFail($id);


        $this->id_carta = $carta->id_carta;


        $this->num_paginas = $carta->num_paginas;

        $this->tipo_material = $carta->tipo_material;

        $this->diseno_url = $carta->diseno_url;

        $this->incluye_fotos = $carta->incluye_fotos;



        $this->editando = true;
    }





    public function actualizar()
    {
        $this->validate();


        $carta = Carta::findOrFail($this->id_carta);



        $carta->update([

            'num_paginas' => $this->num_paginas,

            'tipo_material' => $this->tipo_material,

            'diseno_url' => $this->diseno_url,

            'incluye_fotos' => $this->incluye_fotos,

        ]);



        $this->limpiar();

        $this->listar();

        $this->editando = false;

    }





    public function eliminar($id)
    {

        Carta::findOrFail($id)->delete();


        $this->listar();

    }




    public function cancelar()
    {

        $this->limpiar();

        $this->editando = false;

    }




    private function limpiar()
    {

        $this->reset([

            'id_carta',

            'num_paginas',

            'tipo_material',

            'diseno_url',

            'incluye_fotos',

        ]);

    }




    public function render()
    {
        return view('livewire.carta-main');
    }
}
