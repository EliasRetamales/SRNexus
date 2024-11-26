@extends('adminlte::page')

@section('title', 'Lista de Proyectos')

@section('content_header')
    <h1>Proyectos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Proyectos</h3>
            <div class="card-tools">
                <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Nuevo Proyecto
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="projects-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Habilitado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->client->name }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->code }}</td>
                            <td>{{ $project->description }}</td>
                            <td>{{ $project->enable ? 'Sí' : 'No' }}</td>
                            <td>
                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este proyecto?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#projects-table').DataTable();
        });
    </script>
@stop
