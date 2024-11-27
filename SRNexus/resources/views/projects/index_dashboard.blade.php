@extends('adminlte::page')

@section('title', 'Dashboard de Proyectos')

@section('content_header')
    <h1>Dashboard de Proyectos</h1>
@stop

@section('content')
    <div class="row">
        @foreach ($projects as $project)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">{{ $project->description }}</p>
                        <p class="card-text">
                            <strong>Sensores:</strong> {{ $project->sensors->count() }}
                        </p>
                        <a href="{{ route('sensors.dashboard', $project->id) }}" class="btn btn-primary">Ver Sensores</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
