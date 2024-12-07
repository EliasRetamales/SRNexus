@extends('adminlte::page')

@section('title', 'Estadísticas')

@section('content_header')
    <h1>Gestión de Estadísticas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Estadisticas en periodo: >Insertar valor .env para cron< >"min/hora/dia"<</h3>
            <div class="card-tools">
                <a href="{{ route('stadistics.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Nueva Estadística
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table id="stadistics-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sensor</th>
                        <th>Promedio</th>
                        <th>Máximo</th>
                        <th>Mínimo (MIN)</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stadistics as $stadistic)
                        <tr>
                            <td>{{ $stadistic->id }}</td>
                            <td>{{ $stadistic->sensor->name }}</td>
                            <td>{{ number_format($stadistic->avg, 2) }}</td>
                            <td>{{ number_format($stadistic->max, 2) }}</td>
                            <td>{{ number_format($stadistic->min, 2) }}</td>
                            <td>{{ $stadistic->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('stadistics.show', $stadistic->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('stadistics.edit', $stadistic->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('stadistics.destroy', $stadistic->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta estadística?')">
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
            $('#stadistics-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
@stop
