<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_cliente
 * @property string $nombre
 * @property string $paterno
 * @property string $materno
 * @property string|null $email
 * @property string $telefono
 * @property \Illuminate\Support\Carbon $fecha_registro
 */
#[Fillable([
    'nombre',
    'paterno',
    'materno',
    'email',
    'telefono',
])]
class Cliente extends Model
{
    protected $table = 'cliente';

    protected $primaryKey = 'id_cliente';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'fecha_registro' => 'datetime',
        ];
    }

    /**public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id_cliente');
    }*/
}
