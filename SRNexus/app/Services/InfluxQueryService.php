<?php

namespace App\Services;

use App\Models\InfluxdbConnection;
use InfluxDB2\Client;
use Exception;

class InfluxQueryService
{
    /**
     * Lee datos desde InfluxDB usando la conexión y los parámetros de tiempo.
     *
     * @param InfluxdbConnection $connection
     * @param string $start Fecha/hora de inicio.
     * @param string|null $end Fecha/hora de fin.
     * @param array $filters Filtros adicionales para la consulta.
     * @return array Datos obtenidos desde InfluxDB.
     * @throws Exception
     */
    public function readBatch(InfluxdbConnection $connection, string $start, ?string $end = null, array $filters = [], int $window = 10): array
    {
        // Configurar cliente de InfluxDB
        $client = new Client([
            'url' => $connection->url,
            'token' => $connection->token,
            'org' => $connection->organization,
            'debug' => false,
        ]);

        // Construir la consulta usando InfluxQueryBuilder
        $queryBuilder = new \App\Services\InfluxQueryBuilder();
        $queryBuilder->db($connection->bucket)
            ->range($start, $end)
            ->multiFilters($filters)
            ->window($window, 's')
            ->mean();
        $query = $queryBuilder->get();

        try {
            // Ejecutar la consulta
            $queryApi = $client->createQueryApi();
            $response = $queryApi->query($query);

            // Procesar y devolver los datos en formato array
            return $this->formatResponse($response);
        } catch (Exception $e) {
            throw new Exception("Error al leer datos de InfluxDB: " . $e->getMessage());
        } finally {
            $client->close();
        }
    }

    /**
     * Formatea la respuesta de InfluxDB en un arreglo legible.
     *
     * @param array $response Respuesta cruda de InfluxDB.
     * @return array Datos formateados.
     */
    protected function formatResponse(array $response): array
    {
        $data = [];

        foreach ($response as $table) {
            foreach ($table->records as $record) {
                $data[] = [
                    'time' => $record->getTime(),
                    'field' => $record->getField(),
                    'value' => $record->getValue(),
                    'tags' => $record->getTags(),
                ];
            }
        }

        return $data;
    }
}
