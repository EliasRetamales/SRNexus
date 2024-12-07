@extends('adminlte::page')

@section('title', 'Dashboard de Proyectos')

@section('content_header')
    <h1>Dashboard de Proyectos</h1>
@stop

@section('content')
    <div class="row">
        @foreach ($projects as $project)
            <div class="col-md-4">
                <div class="card bg-info">
                    <div class="card-header">
                        <h3 class="card-title text-white">{{ $project->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $project->description }}</p>
                        <p><strong>Sensores:</strong> {{ $project->sensors->count() }}</p>
                        <a href="{{ route('sensors.dashboard', $project->id) }}" class="btn btn-primary">Ver Sensores</a>
                        <a href="{{ route('projects.sensorTypeView', $project->id) }}" class="btn btn-warning">Ver por Tipo</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
