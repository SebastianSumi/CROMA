<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_tarjeta
 * @property int $id_detalle
 * @property string $estilo
 * @property string $diseno_url
 * @property string|null $material
 * @property int|null $cantidad
 * @property string|null $medidas
 */
#[Fillable([
    //'id_detalle',
    'estilo',
    'diseno_url',
    'material',
    'cantidad',
    'medidas',
])]
class Tarjeta extends Model
{
    protected $table = 'tarjeta';

    protected $primaryKey = 'id_tarjeta';

    public $timestamps = false;

    /**public function detalle(): BelongsTo
    {
        return $this->belongsTo(Detalle::class, 'id_detalle', 'id_detalle');
    }*/
}
