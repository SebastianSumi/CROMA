<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrabajoAnterior extends Model
{
    use HasFactory;

    protected $table = 'trabajos_anteriores';
    protected $primaryKey = 'id_trabajo';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen_url',
        'producto_id',
        'fecha_realizacion',
        'activo'
    ];

    // Opcional: Relación para traer el nombre del producto al que pertenece
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }
}
