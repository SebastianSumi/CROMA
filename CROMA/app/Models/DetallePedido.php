<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_detalle
 * @property int $id_pedido
 * @property int $id_servicio
 * @property int $cantidad
 * @property float $precio_unitario
 * @property float|null $subtotal
 */
#[Fillable([
    'id_pedido',
    'id_servicio',
    'cantidad',
    'precio_unitario',
    'subtotal',
])]
class DetallePedido extends Model
{
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'id_detalle';
    public $incrementing = false;
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_detalle'      => 'integer',
            'id_pedido'       => 'integer',
            'id_servicio'     => 'integer',
            'cantidad'        => 'integer',
            'precio_unitario' => 'decimal:2',
            'subtotal'        => 'decimal:2',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }
}
