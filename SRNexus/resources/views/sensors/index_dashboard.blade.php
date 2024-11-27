@extends('adminlte::page')

@section('title', 'Dashboard de Sensores')

@section('content_header')
    <h1>Dashboard de Sensores para el Proyecto: {{ $project->name }}</h1>
@stop

@section('content')
    <div class="row">
        @foreach ($project->sensors as $sensor)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sensor->name }}</h5>
                        <p class="card-text">
                            <strong>Rango:</strong> {{ $sensor->range_min }} - {{ $sensor->range_max }}<br>
                            <strong>Error:</strong> {{ $sensor->error }}<br>
                            <strong>Sensibilidad:</strong> {{ $sensor->sensitivity ?? 'N/A' }}
                        </p>
                        <!-- Enlace al gráfico del sensor -->
                        <a href="{{ route('sensors.chart', $sensor->id) }}" class="btn btn-primary">Ver Gráficos</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
