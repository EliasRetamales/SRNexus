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
     * @param int $window Duración de la ventana en segundos.
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
            ->aggregateWindow($window, 's', 'mean');
        $query = $queryBuilder->get();

        try {
            // Ejecutar la consulta
            $queryApi = $client->createQueryApi();
            $response = $queryApi->query($query);

            // Procesar y devolver la consulta y los datos en formato array
            return [
                'query' => $query, // Agregamos la consulta generada
                'data' => $this->formatResponse($response),
            ];
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
                // Gestiona tags y campos según la referencia
                $tags = [];
                $fields = [];

                foreach ($record->values as $key => $value) {
                    if (!str_starts_with($key, '_')) {
                        $tags[$key] = $value; // Es un tag
                    } else {
                        $fields[$key] = $value; // Es un campo
                    }
                }

                // Extrae el tag 'sensor', si está disponible
                $sensorTag = $tags['sensor'] ?? null;
                unset($tags['sensor']); // Elimina 'sensor' de los tags generales

                $data[] = [
                    'time' => $fields['_time'] ?? null,
                    'field' => $fields['_field'] ?? null,
                    'value' => $fields['_value'] ?? null,
                    'sensor' => $sensorTag,
                    'tags' => $tags,
                ];
            }
        }

        return $data;
    }



}
