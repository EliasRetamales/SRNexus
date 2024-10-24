<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfluxdbConnection extends Model
{
    protected $fillable = [
        'name',
        'url',
        'token',
        'bucket',
        'organization',
    ];

    // Mutator para cifrar el token al guardar
    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = encrypt($value);
    }

    // Accessor para descifrar el token al acceder
    public function getTokenAttribute($value)
    {
        return decrypt($value);
    }
}
