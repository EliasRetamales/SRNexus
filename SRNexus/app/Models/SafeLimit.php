<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeLimit extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array
     */
    protected $fillable = [
        'max_value',
        'min_value',
        'enable',
    ];

    /**
     * Relación con el modelo Sensor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }
}
