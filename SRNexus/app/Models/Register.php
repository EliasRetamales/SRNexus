<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'measurement_time',
        'enable',
        'sensor_id',
    ];

    protected $casts = [
        'measurement_time' => 'datetime',
    ];

    /**
     * Relación con el modelo Alert.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

}
