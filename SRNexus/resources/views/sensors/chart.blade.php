@extends('adminlte::page')

@section('title', 'Gráfico del Sensor')

@section('content_header')
    <h1 style="color: white;">Datos del Sensor: {{ $sensor->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: white; border: 1px solid #ddd;">
                <div class="card-header" style="background-color: #f9f9f9; color: black;">
                    <h3 class="card-title" style="color: black;">Gráfico del Sensor</h3>
                </div>
                <div class="card-body">
                    <canvas id="sensorChart" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: white; border: 1px solid #ddd;">
                <div class="card-header" style="background-color: #f9f9f9; color: black;">
                    <h3 class="card-title" style="color: black;">Datos del Sensor</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="sensorTable">
                        <thead>
                            <tr style="color: black;">
                                <th>Tiempo de Medición</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registers as $register)
                                <tr style="color: black;">
                                    <td>{{ \Carbon\Carbon::parse($register->measurement_time)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $register->value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('sensorChart').getContext('2d');

            let labels = {!! $registers->pluck('measurement_time')->map(fn($time) => \Carbon\Carbon::parse($time)->format('H:i:s')) !!};
            let dataValues = {!! $registers->pluck('value') !!};

            const maxDataPoints = 40; // Máximo de puntos visibles
            let remainingLabels = labels.slice(maxDataPoints);
            let remainingValues = dataValues.slice(maxDataPoints);

            labels = labels.slice(0, maxDataPoints);
            dataValues = dataValues.slice(0, maxDataPoints);

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Valor del Sensor',
                        data: dataValues,
                        borderColor: 'rgba(60,141,188,0.8)',
                        backgroundColor: 'rgba(60,141,188,0.3)',
                        fill: true,
                        tension: 0.4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tiempo'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Valor'
                            },
                            beginAtZero: false
                        }
                    }
                }
            });

            // Actualización dinámica
            const updateInterval = 5000; // 5 segundos
            function updateChart() {
                if (remainingLabels.length > 0 && remainingValues.length > 0) {

                    const nextLabel = remainingLabels.shift();
                    const nextValue = remainingValues.shift();

                    labels.push(nextLabel);
                    dataValues.push(nextValue);

                    // Mantener máximo 40 datos
                    if (labels.length > maxDataPoints) {
                        labels.shift();
                        dataValues.shift();
                    }

                    // Actualizar gráfico
                    chart.data.labels = labels;
                    chart.data.datasets[0].data = dataValues;
                    chart.update();
                }
            }

            setInterval(updateChart, updateInterval);

            $('#sensorTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: 'Descargar CSV',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: [0, 1] // Exporta las columnas Tiempo de Medición y Valor
                        }
                    }
                ],
                searching: false,
            });
        });
    </script>
@stop

