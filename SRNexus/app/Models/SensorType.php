<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'description'];

    /**
     * Relationship: SensorType has many Sensors.
     */
    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }
}
