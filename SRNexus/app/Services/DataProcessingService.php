<?php

namespace App\Services;

use App\Models\Sensor;
use App\Models\Register;
use App\Models\Alert;
use App\Models\Project;

class DataProcessingService
{
    /**
     * Procesa los datos obtenidos de InfluxDB para un proyecto específico.
     *
     * @param Project $project
     * @param array $data Datos obtenidos de InfluxDB.
     * @return void
     */
    public function processData(Project $project, array $data): void
    {
        foreach ($data as $record) {
            // Obtener información del sensor desde el tag
            $sensorTag = $record['sensor'] ?? null;

            if (!$sensorTag) {
                // Saltar si no hay un tag "sensor"
                continue;
            }

            // Buscar el sensor por nombre y proyecto
            $sensor = Sensor::where('name', $sensorTag)
                ->where('project_id', $project->id)
                ->first();

            // Crear el sensor si no existe
            if (!$sensor) {
                $sensor = Sensor::create([
                    'project_id' => $project->id,
                    'name' => $sensorTag,
                    'enable' => true,
                    'range_max' => 300, // Valores por defecto
                    'range_min' => 0,
                    'error' => 0.1,
                ]);
            }

            // Crear un registro para el sensor
            $register = Register::create([
                'sensor_id' => $sensor->id,
                'value' => $record['value'],
                'measurement_time' => $record['time'],
                'enable' => true,
            ]);

            // Verificar límites de alerta
            if ($sensor->safe_limit_id) {
                $safeLimit = $sensor->safeLimit;

                if (
                    $safeLimit &&
                    ($register->value < $safeLimit->min_value || $register->value > $safeLimit->max_value)
                ) {
                    // Crear una alerta si los valores están fuera del límite
                    Alert::create([
                        'sensor_id' => $sensor->id,
                        'register_id' => $register->id,
                        'checked' => false,
                        'enable' => true,
                    ]);
                }
            }
        }
    }
}
