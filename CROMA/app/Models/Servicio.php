<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'nombre_servicio',
    'descripcion',
    'precio_base',
    'activo',
])]
class Servicio extends Model
{
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    public $incrementing = false;
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_servicio' => 'integer',
            'precio_base' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }
}
