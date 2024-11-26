@extends('adminlte::page')

@section('title', 'Sensores')

@section('content_header')
    <h1>Gestión de Sensores</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Sensores</h3>
            <div class="card-tools">
                <a href="{{ route('sensors.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Nuevo Sensor
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table id="sensors-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Proyecto</th>
                        <th>Límite Seguro</th>
                        <th>Rango</th>
                        <th>Error</th>
                        <th>Sensibilidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sensors as $sensor)
                        <tr>
                            <td>{{ $sensor->id }}</td>
                            <td>{{ $sensor->name }}</td>
                            <td>{{ $sensor->project->name }}</td>
                            <td>{{ $sensor->safeLimit->max_value ?? 'N/A' }}</td>
                            <td>{{ $sensor->range_min }} - {{ $sensor->range_max }}</td>
                            <td>{{ $sensor->error }}</td>
                            <td>{{ $sensor->sensitivity ?? 'N/A' }}</td>
                            <td>
                                @if ($sensor->enable)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('sensors.show', $sensor->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('sensors.edit', $sensor->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este sensor?')">
                                        <i class="fa fa-trash"></i> Eliminar
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

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sensors-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
@stop
