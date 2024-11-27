@extends('adminlte::page')

@section('title', 'Editar Conexión a InfluxDB')

@section('content_header')
    <h1>Editar Conexión a InfluxDB</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición</h3>
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
            <form action="{{ route('influxdb_connections.update', $influxdbConnection->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="project_id">Proyecto</label>
                    <select name="project_id" id="project_id" class="form-control" required>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ $influxdbConnection->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Nombre de la Conexión</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $influxdbConnection->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="url" name="url" id="url" class="form-control" value="{{ old('url', $influxdbConnection->url) }}" required>
                </div>

                <div class="form-group">
                    <label for="token">Token</label>
                    <textarea name="token" id="token" class="form-control" rows="3" required>{{ old('token', $influxdbConnection->token) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="bucket">Bucket</label>
                    <input type="text" name="bucket" id="bucket" class="form-control" value="{{ old('bucket', $influxdbConnection->bucket) }}" required>
                </div>

                <div class="form-group">
                    <label for="organization">Organización</label>
                    <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization', $influxdbConnection->organization) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </div>
@stop
