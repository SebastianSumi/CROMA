<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_carta
 * @property int $id_detalle
 * @property int|null $num_paginas
 * @property string|null $tipo_material
 * @property string|null $diseno_url
 * @property bool $incluye_fotos
 */
#[Fillable([
    //'id_detalle',
    'num_paginas',
    'tipo_material',
    'diseno_url',
    'incluye_fotos',
])]
class Carta extends Model
{
    protected $table = 'carta';

    protected $primaryKey = 'id_carta';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'incluye_fotos' => 'boolean',
        ];
    }

    /**public function detalle(): BelongsTo
    {
        return $this->belongsTo(Detalle::class, 'id_detalle', 'id_detalle');
    }*/
}
