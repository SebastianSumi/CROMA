<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_lanyard
 * @property int $id_detalle
 * @property string|null $color
 * @property string|null $texto_impreso
 */
#[Fillable([
    'id_detalle',
    'color',
    'texto_impreso',
])]
class LanyardCinta extends Model
{
    protected $table = 'lanyard_cinta';
    protected $primaryKey = 'id_lanyard';
    public $incrementing = false;
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_lanyard' => 'integer',
            'id_detalle' => 'integer',
        ];
    }

    public function detallePedido(): BelongsTo
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalle', 'id_detalle');
    }
}
