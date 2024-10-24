<?php

namespace App\Services;

use InfluxDB2\Client;
use App\Models\InfluxdbConnection;

class InfluxdbService
{
    protected $clients = [];

    public function getClient($connectionId)
    {
        if (isset($this->clients[$connectionId])) {
            return $this->clients[$connectionId];
        }

        $config = InfluxdbConnection::find($connectionId);

        if (!$config) {
            throw new \Exception("Conexión InfluxDB no encontrada.");
        }

        $client = new Client([
            'url' => $config->url,
            'token' => decrypt($config->token),
            'bucket' => $config->bucket,
            'org' => $config->organization,
        ]);

        $this->clients[$connectionId] = $client;

        return $client;
    }
}
