@extends('adminlte::page')

@section('title', 'Nueva Conexión a InfluxDB')

@section('content_header')
    <h1>Crear Nueva Conexión</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Conexión</h3>
            <div class="card-tools">
                <a href="{{ route('influxdb_connections.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('influxdb_connections.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="project_id">Proyecto</label>
                    <select name="project_id" id="project_id" class="form-control" required>
                        <option value="">Seleccione un Proyecto</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Nombre de la Conexión</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese un nombre para la conexión" required>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="url" name="url" id="url" class="form-control" placeholder="Ingrese la URL de la conexión" required>
                </div>
                <div class="form-group">
                    <label for="token">Token</label>
                    <textarea name="token" id="token" class="form-control" placeholder="Ingrese el token de autenticación" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="bucket">Bucket</label>
                    <input type="text" name="bucket" id="bucket" class="form-control" placeholder="Ingrese el bucket" required>
                </div>
                <div class="form-group">
                    <label for="organization">Organización</label>
                    <input type="text" name="organization" id="organization" class="form-control" placeholder="Ingrese la organización" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </form>
        </div>
    </div>
@stop
