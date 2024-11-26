@extends('adminlte::page')

@section('title', 'Detalles del Proyecto')

@section('content_header')
    <h1>Detalles del Proyecto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Proyecto</h3>
            <div class="card-tools">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar Proyecto
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $project->id }}</td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td>{{ $project->client->name }}</td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $project->name }}</td>
                </tr>
                <tr>
                    <th>Código</th>
                    <td>{{ $project->code }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td>{{ $project->description }}</td>
                </tr>
                <tr>
                    <th>Habilitado</th>
                    <td>{{ $project->enable ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Creado el</th>
                    <td>{{ $project->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Última Actualización</th>
                    <td>{{ $project->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
