<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_diseno
 * @property int $id_detalle
 * @property string $tipo
 * @property string|null $arch_fuente_url
 * @property string $estado_aprobacion
 * @property string $arch_result_url
 */
#[Fillable([
    'id_detalle',
    'tipo',
    'arch_fuente_url',
    'estado_aprobacion',
    'arch_result_url',
])]
class DisenoGrafico extends Model
{
    protected $table = 'diseno_grafico';
    protected $primaryKey = 'id_diseno';
    public $incrementing = false;
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_diseno' => 'integer',
            'id_detalle' => 'integer',
        ];
    }

    public function detallePedido(): BelongsTo
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalle', 'id_detalle');
    }
}
