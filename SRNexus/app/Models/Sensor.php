<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'safe_limit_id',
        'sensor_type_id',
        'name',
        'enable',
        'range_max',
        'range_min',
        'error',
        'sensitivity',
    ];

    /**
     * Relación con el modelo Project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relación con el modelo SafeLimite (Opcional).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function safeLimit()
    {
        return $this->belongsTo(SafeLimit::class);
    }

    /**
     * Relación con el modelo Alert.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function registers()
    {
        return $this->hasMany(Register::class);
    }

    public function sensorType()
    {
        return $this->belongsTo(SensorType::class);
    }

}
