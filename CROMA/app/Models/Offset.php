<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_offset
 * @property int $id_detalle
 * @property string $tipo_material
 * @property int|null $num_paginas
 * @property string|null $acabado
 * @property string $diseno_url
 */
#[Fillable([
    'id_detalle',
    'tipo_material',
    'num_paginas',
    'acabado',
    'diseno_url',
])]
class Offset extends Model
{
    protected $table = 'servicio_offset';

    protected $primaryKey = 'id_offset';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_offset' => 'integer',
            'id_detalle' => 'integer',
            'num_paginas' => 'integer',
        ];
    }

    public function detallePedido(): BelongsTo
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalle', 'id_detalle');
    }
}
