<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_fotocheck
 * @property int $id_detalle
 * @property string|null $nombre_titular
 * @property string|null $cargo
 * @property string|null $foto_url
 * @property string|null $institucion
 * @property string|null $codigo_trabajador
 */
#[Fillable([
    'id_detalle',
    'nombre_titular',
    'cargo',
    'foto_url',
    'institucion',
    'codigo_trabajador',
])]
class FotocheckPvc extends Model
{
    protected $table = 'fotocheck_pvc';
    protected $primaryKey = 'id_fotocheck';
    public $incrementing = false;
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_fotocheck' => 'integer',
            'id_detalle' => 'integer',
        ];
    }

    public function detallePedido(): BelongsTo
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalle', 'id_detalle');
    }
}
