<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;

class ClienteMain extends Component
{
    public $clientes;

    public $id_cliente;

    public $nombre = '';
    public $paterno = '';
    public $materno = '';
    public $email = '';
    public $telefono = '';

    public $editando = false;

    protected $rules = [
        'nombre' => 'required|string|max:100',
        'paterno' => 'required|string|max:100',
        'materno' => 'required|string|max:100',
        'email' => 'nullable|email|max:255',
        'telefono' => 'required|string|max:20',
    ];

    public function mount()
    {
        $this->cargarClientes();
    }

    public function cargarClientes()
    {
        $this->clientes = Cliente::all();
    }

    public function guardar()
    {
        $this->validate();

        Cliente::create([
            'nombre' => $this->nombre,
            'paterno' => $this->paterno,
            'materno' => $this->materno,
            'email' => $this->email,
            'telefono' => $this->telefono,
        ]);

        $this->limpiarFormulario();
        $this->cargarClientes();
    }

    public function editar($id)
    {
        $cliente = Cliente::findOrFail($id);

        $this->id_cliente = $cliente->id_cliente;
        $this->nombre = $cliente->nombre;
        $this->paterno = $cliente->paterno;
        $this->materno = $cliente->materno;
        $this->email = $cliente->email;
        $this->telefono = $cliente->telefono;

        $this->editando = true;
    }

    public function actualizar()
    {
        $this->validate();

        $cliente = Cliente::findOrFail($this->id_cliente);

        $cliente->update([
            'nombre' => $this->nombre,
            'paterno' => $this->paterno,
            'materno' => $this->materno,
            'email' => $this->email,
            'telefono' => $this->telefono,
        ]);

        $this->limpiarFormulario();
        $this->cargarClientes();

        $this->editando = false;
    }

    public function eliminar($id)
    {
        Cliente::findOrFail($id)->delete();

        $this->cargarClientes();
    }

    public function cancelar()
    {
        $this->limpiarFormulario();
        $this->editando = false;
    }

    private function limpiarFormulario()
    {
        $this->reset([
            'id_cliente',
            'nombre',
            'paterno',
            'materno',
            'email',
            'telefono',
        ]);
    }

    public function render()
    {
        return view('livewire.cliente-main');
    }
}
