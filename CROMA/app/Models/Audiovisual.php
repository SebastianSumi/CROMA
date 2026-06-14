<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_edicion
 * @property int $id_detalle
 * @property string $tipo
 * @property int|null $duracion_segundos
 * @property string|null $archivo_fuente
 * @property string|null $formato_salida
 */
#[Fillable([
    'id_detalle',
    'tipo',
    'duracion_segundos',
    'archivo_fuente',
    'formato_salida',
])]
class Audiovisual extends Model
{
    protected $table = 'edicion_audiovisual';

    protected $primaryKey = 'id_edicion';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_edicion' => 'integer',
            'id_detalle' => 'integer',
            'duracion_segundos' => 'integer',
        ];
    }

    public function detallePedido(): BelongsTo
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalle', 'id_detalle');
    }
}
