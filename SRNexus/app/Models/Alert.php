<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array
     */
    protected $fillable = [
        'sensor_id',
        'register_id',
        'checked',
        'enable',
    ];

    /**
     * Relación con el modelo Sensor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    /**
     * Relación con el modelo Register.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function register()
    {
        return $this->belongsTo(Register::class);
    }
}
