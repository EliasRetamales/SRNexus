<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InfluxDB2\Client;
use InfluxDB2\Point;
use InfluxDB2\Model\WritePrecision;

class InfluxTestController extends Controller
{
    public function testConnection()
    {
        // Obtener la configuración desde las variables de entorno
        $influxConfig = [
            'url' => env('INFLUXDB_URL_TEST'),
            'token' => env('INFLUXDB_TOKEN_TEST'),
            'org' => env('INFLUXDB_ORG_TEST'),
            'bucket' => env('INFLUXDB_BUCKET_TEST'),
        ];

        // Validar que las variables de entorno estén definidas
        if (empty($influxConfig['url']) || empty($influxConfig['token']) || empty($influxConfig['org'])) {
            return response()->json([
                'success' => false,
                'message' => 'Las credenciales de InfluxDB no están definidas en las variables de entorno.',
            ], 500);
        }

        // Crear una instancia del cliente de InfluxDB
        $client = new Client([
            'url' => $influxConfig['url'],
            'token' => $influxConfig['token'],
            'org' => $influxConfig['org'],
        ]);

        try {
            // Crear una instancia del Query API
            $queryApi = $client->createQueryApi();

            // Realizar una consulta para obtener los buckets
            $query = 'buckets()';
            $tables = $queryApi->query($query);

            // Procesar los resultados para obtener los nombres de los buckets
            $buckets = [];
            foreach ($tables as $table) {
                foreach ($table->records as $record) {
                    // Acceder al valor de la columna 'name'
                    $buckets[] = $record->values['name'];
                }
            }

            // Devolver una respuesta exitosa con la lista de buckets
            return response()->json([
                'success' => true,
                'message' => 'Conexión exitosa a InfluxDB.',
                'buckets' => $buckets,
            ]);
        } catch (\Exception $e) {
            // Manejar errores y devolver una respuesta de error
            return response()->json([
                'success' => false,
                'message' => 'Error al conectar con InfluxDB: ' . $e->getMessage(),
            ], 500);
        } finally {
            // Cerrar el cliente
            $client->close();
        }
    }

    public function writeData()
    {
        // Obtener la configuración desde las variables de entorno
        $influxConfig = [
            'url' => env('INFLUXDB_URL_TEST'),
            'token' => env('INFLUXDB_TOKEN_TEST'),
            'org' => env('INFLUXDB_ORG_TEST'),
            'bucket' => env('INFLUXDB_BUCKET_TEST'),
        ];

        // Validar que las variables de entorno estén definidas
        if (empty($influxConfig['url']) || empty($influxConfig['token']) || empty($influxConfig['org']) || empty($influxConfig['bucket'])) {
            return response()->json([
                'success' => false,
                'message' => 'Las credenciales de InfluxDB no están definidas en las variables de entorno.',
            ], 500);
        }

        // Crear una instancia del cliente de InfluxDB
        $client = new Client([
            'url' => $influxConfig['url'],
            'token' => $influxConfig['token'],
            'org' => $influxConfig['org'],
        ]);

        try {
            // **Escribir un registro en InfluxDB**

            // Crear un punto de datos
            $point = new Point('temperature_measurement'); // Nombre de la medición

            $point->addTag('sensor_type', 'PT100')        // Etiqueta: tipo de sensor
                  ->addTag('location', 'Laboratorio')     // Etiqueta: lugar del sensor
                  ->addTag('position', 'Posición 1')      // Etiqueta: posición del sensor
                  ->addField('temperature', 100.0)        // Campo: temperatura medida
                  ->time(time(), WritePrecision::S);      // Marca de tiempo actual en segundos

            // Crear una instancia del Write API
            $writeApi = $client->createWriteApi();

            // Escribir el punto en InfluxDB
            $writeApi->write($point, WritePrecision::S, $influxConfig['bucket'], $influxConfig['org']);

            // Cerrar el cliente
            $client->close();

            // Devolver una respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Registro escrito exitosamente en InfluxDB.',
            ]);
        } catch (\Exception $e) {
            // Manejar errores y devolver una respuesta de error
            return response()->json([
                'success' => false,
                'message' => 'Error al escribir en InfluxDB: ' . $e->getMessage(),
            ], 500);
        }
    }
}
