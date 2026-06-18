<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_pago
 * @property int $id_pedido
 * @property float $monto
 * @property \Carbon\Carbon $fecha_pago
 */
#[Fillable([
    'id_pedido',
    'monto',
    'fecha_pago',
])]
class Pago extends Model
{
    protected $table = 'pago';

    protected $primaryKey = 'id_pago';

    public $incrementing = false; // Usas IDs manuales

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_pago' => 'integer',
            'id_pedido' => 'integer',
            'monto' => 'decimal:2',
            'fecha_pago' => 'datetime',
        ];
    }

    public function pedido(): BelongsTo{return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');}
}
