@extends('adminlte::page')

@section('title', 'Límites Seguros')

@section('content_header')
    <h1>Gestión de Límites Seguros</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Límites Seguros</h3>
            <div class="card-tools">
                <a href="{{ route('safe_limits.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Nuevo Límite Seguro
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="safe-limits-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Valor Máximo</th>
                        <th>Valor Mínimo</th>
                        <th>Habilitado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($safeLimits as $safeLimit)
                        <tr>
                            <td>{{ $safeLimit->id }}</td>
                            <td>{{ $safeLimit->max_value ?? 'No definido' }}</td>
                            <td>{{ $safeLimit->min_value ?? 'No definido' }}</td>
                            <td>
                                @if ($safeLimit->enable)
                                    <span class="badge badge-success">Sí</span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('safe_limits.show', $safeLimit->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('safe_limits.edit', $safeLimit->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('safe_limits.destroy', $safeLimit->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este límite seguro?')">
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
            $('#safe-limits-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
@stop
