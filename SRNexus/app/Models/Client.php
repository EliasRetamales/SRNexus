<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'activity',
        'rut',
        'enable',
    ];

    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    // protected $table = 'clients'; // No es necesario si sigue la convención

    /**
     * Indica si el modelo debe tener marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = true; // Por defecto es true

    /**
     * La clave primaria asociada a la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id'; // Por defecto es 'id'

    /**
     * El tipo de clave primaria del modelo.
     *
     * @var string
     */
    // protected $keyType = 'int'; // Por defecto es 'int'

    /**
     * Relación con el modelo Project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
