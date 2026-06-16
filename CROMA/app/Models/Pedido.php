<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_pedido
 * @property int $id_cliente
 * @property \Carbon\Carbon $fecha
 * @property string $estado
 * @property float|null $total
 * @property string|null $observaciones
 * @property \Carbon\Carbon $fecha_registro
 */
#[Fillable([
    'id_cliente',
    'fecha',
    'estado',
    'total',
    'observaciones',
    'fecha_registro',
])]
class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    public $incrementing = false;
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_pedido' => 'integer',
            'id_cliente' => 'integer',
            'fecha' => 'date',
            'total' => 'decimal:2',
            'fecha_registro' => 'datetime',
        ];
    }

    // Relaciones principales
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'id_pedido', 'id_pedido');
    }
}
