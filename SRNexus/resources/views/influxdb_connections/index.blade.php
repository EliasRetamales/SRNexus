@extends('adminlte::page')

@section('title', 'Conexiones a InfluxDB')

@section('content_header')
    <h1>Conexiones a InfluxDB</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Conexiones</h3>
            <div class="card-tools">
                <a href="{{ route('influxdb_connections.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Nueva Conexión
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="connections-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Proyecto</th>
                        <th>Bucket</th>
                        <th>Organización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($connections as $connection)
                        <tr>
                            <td>{{ $connection->id }}</td>
                            <td>{{ $connection->name }}</td>
                            <td>{{ $connection->project->name }}</td>
                            <td>{{ $connection->bucket }}</td>
                            <td>{{ $connection->organization }}</td>
                            <td>
                                <a href="{{ route('influxdb_connections.show', $connection->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('influxdb_connections.edit', $connection->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('influxdb_connections.destroy', $connection->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta conexión?')">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#connections-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
@stop
