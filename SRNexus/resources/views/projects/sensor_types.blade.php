@extends('adminlte::page')

@section('title', 'Sensores por Tipo')

@section('content_header')
    <h1>Sensores Agrupados por Tipo: {{ $project->name }}</h1>
@stop

@section('content')
    @foreach ($sensorTypes as $typeId => $sensors)
        <div class="card shadow-sm" style="background-color: #f7f9fc; border: 1px solid #ddd; margin-bottom: 20px;">
            <div class="card-header" style="background-color: #e8eff7; color: #333;">
                <h3 class="card-title">Tipo de Sensor: {{ $sensors->first()->sensorType->type ?? 'N/A' }}</h3>
                <div class="card-tools float-right">
                    <select class="form-control input-sm time-range-select" data-type-id="{{ $typeId }}">
                        <option value="5">5 minutos</option>
                        <option value="15">15 minutos</option>
                        <option value="30">30 minutos</option>
                        <option value="60">1 hora</option>
                        <option value="360">6 horas</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chart-type-{{ $typeId }}" style="max-height: 400px;"></canvas>
            </div>
        </div>

        <div class="card shadow-sm" style="background-color: #f7f9fc; border: 1px solid #ddd; margin-bottom: 20px;">
            <div class="card-header" style="background-color: #e8eff7; color: #333;">
                <h3 class="card-title">Tabla de Sensores del Tipo: {{ $sensors->first()->sensorType->type ?? 'N/A' }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" style="color:black;">
                    <thead >
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Última Lectura</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sensors as $sensor)
                            <tr>
                                <td>{{ $sensor->id }}</td>
                                <td>{{ $sensor->name }}</td>
                                <td>{{ $sensor->registers->last()->measurement_time ?? 'N/A' }}</td>
                                <td>{{ $sensor->registers->last()->value ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @foreach ($sensorTypes as $typeId => $sensors)
                const ctxType{{ $typeId }} = document.getElementById('chart-type-{{ $typeId }}').getContext('2d');

                // Inicialización de datos
                let labelsType{{ $typeId }} = [
                    @foreach ($sensors->pluck('registers')->flatten()->sortBy('measurement_time') as $register)
                        "{{ \Carbon\Carbon::parse($register->measurement_time)->format('H:i:s') }}",
                    @endforeach
                ];
                let datasetsType{{ $typeId }} = [
                    @foreach ($sensors as $sensor)
                        {
                            label: "{{ $sensor->name }}",
                            data: [
                                @foreach ($sensor->registers as $register)
                                    {{ $register->value }},
                                @endforeach
                            ],
                            borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.8)`,
                            fill: false,
                            tension: 0.4,
                            yAxisID: 'y-axis-{{ $loop->index }}',
                        },
                    @endforeach
                ];

                const chartType{{ $typeId }} = new Chart(ctxType{{ $typeId }}, {
                    type: 'line',
                    data: {
                        labels: labelsType{{ $typeId }},
                        datasets: datasetsType{{ $typeId }},
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tiempo',
                                },
                            },
                            y: [
                                @foreach ($sensors as $sensor)
                                    {
                                        id: 'y-axis-{{ $loop->index }}',
                                        type: 'linear',
                                        position: 'left',
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Valor ({{ $sensor->name }})',
                                        },
                                    },
                                @endforeach
                            ],
                        },
                    },
                });

                // Manejar el cambio de rango de tiempo
                document.querySelector(`.time-range-select[data-type-id="{{ $typeId }}"]`).addEventListener('change', function () {
                    const range = this.value;

                });
            @endforeach
        });
    </script>
@stop
