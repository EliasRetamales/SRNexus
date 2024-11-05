<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'name',
        'code',
        'description',
        'enable',
    ];

    /**
     * Relación con el modelo Client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relación con el modelo InfluxdbConnection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function influxdbConnections()
    {
        return $this->hasMany(InfluxdbConnection::class);
    }
}
