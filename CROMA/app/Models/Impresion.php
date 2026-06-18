<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_impresion
 * @property int $id_detalle
 * @property string $tipo_documento
 * @property string $tipo_papel
 * @property string $tipo_tinta
 * @property string|null $formato
 * @property string $diseno_url
 */
#[Fillable([
    'id_detalle',
    'tipo_documento',
    'tipo_papel',
    'tipo_tinta',
    'formato',
    'diseno_url',
])]
class Impresion extends Model
{
    protected $table = 'impresion';

    protected $primaryKey = 'id_impresion';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_impresion' => 'integer',
            'id_detalle' => 'integer',
        ];
    }

    public function detallePedido(): BelongsTo {return $this->belongsTo(DetallePedido::class, 'id_detalle', 'id_detalle');}
}
