<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfluxdbConnection extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'url',
        'token',
        'bucket',
        'organization',
    ];

    /**
     * Mutator para cifrar el token al guardar
     */
    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = encrypt($value);
    }

    /**
     * Accessor para descifrar el token al acceder
     */
    public function getTokenAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Relación con el modelo Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
