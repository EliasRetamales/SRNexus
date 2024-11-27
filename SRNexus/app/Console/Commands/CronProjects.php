<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Services\InfluxQueryService;
use App\Services\DataProcessingService;

class CronProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lee los proyectos disponibles y sus conexiones a InfluxDB, mostrando datos en consola hasta que se presione "q".';

    /**
     * Instance of InfluxQueryService.
     *
     * @var InfluxQueryService
     */
    protected $influxService;

    /**
     * Instance of DataProcessingService.
     *
     * @var DataProcessingService
     */
    protected $dataProcessingService;

    /**
     * Create a new command instance.
     */
    public function __construct(InfluxQueryService $influxService, DataProcessingService $dataProcessingService)
    {
        parent::__construct();
        $this->influxService = $influxService;
        $this->dataProcessingService = $dataProcessingService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mostrando proyectos, conexiones y datos de InfluxDB. Presione "q" para salir.');

        while (true) {
            // Obtener todos los proyectos con sus conexiones a InfluxDB
            $projects = Project::with('influxdbConnections')->get();

            // Limpiar la pantalla
            system('clear');

            // Mostrar los proyectos y sus conexiones
            $this->info("Proyectos disponibles y conexiones:");
            foreach ($projects as $project) {
                // $projectModel = Project::where($project->id);
                $project = Project::find($project->id);
                $this->line("ID: {$project->id} | Nombre: {$project->name} | Código: {$project->code}");

                if ($project->influxdbConnections->isEmpty()) {
                    $this->line("  No tiene conexiones a InfluxDB asociadas.");
                } else {
                    foreach ($project->influxdbConnections as $connection) {
                        $this->line("  - Conexión ID: {$connection->id}");
                        $this->line("    Nombre: {$connection->name}");
                        $this->line("    URL: {$connection->url}");
                        $this->line("    Bucket: {$connection->bucket}");
                        $this->line("    Organización: {$connection->organization}");

                        // Llamar a readBatch para esta conexión
                        try {
                            $response = $this->influxService->readBatch(
                                $connection,
                                '-60s',     // Start (últimos 60 segundos)
                                null,       // End (no especificado)
                                [],         // Filtros adicionales (vacío por ahora)
                                5          // Ventana de tiempo (20 segundos)
                            );

                            // Mostrar la consulta generada
                            $this->line("    Consulta generada:");
                            $this->line("    " . $response['query']);

                            // Mostrar datos obtenidos
                            $this->line("    Datos de InfluxDB:");
                            foreach ($response['data'] as $record) {
                                $this->line("      - Time: {$record['time']}, Field: {$record['field']}, Value: {$record['value']}, Sensor: {$record['sensor']}");
                            }

                            // Procesar los datos
                            $this->dataProcessingService->processData($project, $response['data']);
                        } catch (\Exception $e) {
                            $this->error("    Error al consultar datos: " . $e->getMessage());
                        }
                    }
                }
            }

            // Mostrar mensaje de salida
            // $this->info("\nPresione 'q' y luego ENTER para salir.");

            // Esperar entrada del usuario
            // $input = trim(fgets(STDIN));

            // if (strtolower($input) === 'q') {
            //     $this->info("Saliendo...");
            //     break;
            // }

            // Esperar 1 minuto antes de la próxima actualización
            sleep(30);
        }
    }
}
