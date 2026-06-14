<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tarjeta;

class TarjetaMain extends Component
{
    public $tarjetas;

    public $id_tarjeta;

    public $estilo = '';
    public $diseno_url = '';
    public $material = '';
    public $cantidad = null;
    public $medidas = '';

    public $editando = false;


    protected $rules = [
        'estilo' => 'required|string|max:100',
        'diseno_url' => 'required|string|max:255',
        'material' => 'nullable|string|max:100',
        'cantidad' => 'nullable|integer',
        'medidas' => 'nullable|string|max:100',
    ];


    public function mount()
    {
        $this->listar();
    }


    public function listar()
    {
        $this->tarjetas = Tarjeta::all();
    }


    public function guardar()
    {
        $this->validate();


        Tarjeta::create([
            'estilo' => $this->estilo,
            'diseno_url' => $this->diseno_url,
            'material' => $this->material,
            'cantidad' => $this->cantidad,
            'medidas' => $this->medidas,
        ]);


        $this->limpiar();
        $this->listar();
    }


    public function editar($id)
    {
        $tarjeta = Tarjeta::findOrFail($id);


        $this->id_tarjeta = $tarjeta->id_tarjeta;

        $this->estilo = $tarjeta->estilo;
        $this->diseno_url = $tarjeta->diseno_url;
        $this->material = $tarjeta->material;
        $this->cantidad = $tarjeta->cantidad;
        $this->medidas = $tarjeta->medidas;


        $this->editando = true;
    }


    public function actualizar()
    {
        $this->validate();


        $tarjeta = Tarjeta::findOrFail($this->id_tarjeta);


        $tarjeta->update([
            'estilo' => $this->estilo,
            'diseno_url' => $this->diseno_url,
            'material' => $this->material,
            'cantidad' => $this->cantidad,
            'medidas' => $this->medidas,
        ]);


        $this->limpiar();
        $this->listar();

        $this->editando = false;
    }


    public function eliminar($id)
    {
        Tarjeta::findOrFail($id)->delete();

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
            'id_tarjeta',
            'estilo',
            'diseno_url',
            'material',
            'cantidad',
            'medidas',
        ]);
    }


    public function render()
    {
        return view('livewire.tarjeta-main');
    }
}
