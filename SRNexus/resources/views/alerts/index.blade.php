@extends('adminlte::page')

@section('title', 'Alertas')

@section('content_header')
    <h1>Gestión de Alertas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Alertas</h3>
            <div class="card-tools">
                <a href="{{ route('alerts.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Nueva Alerta
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="alerts-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sensor</th>
                        <th>Registro</th>
                        <th>Revisada</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alerts as $alert)
                        <tr>
                            <td>{{ $alert->id }}</td>
                            <td>{{ $alert->sensor->name }}</td>
                            <td>{{ $alert->register->value }}</td>
                            <td>
                                @if ($alert->checked)
                                    <span class="badge badge-success">Sí</span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </td>
                            <td>
                                @if ($alert->enable)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('alerts.show', $alert->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('alerts.edit', $alert->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('alerts.destroy', $alert->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta alerta?')">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                                <!-- Botones para ir a Sensor o Registro -->
                                <a href="{{ route('sensors.show', $alert->sensor_id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-microchip"></i> Ver Sensor
                                </a>
                                <a href="{{ route('registers.show', $alert->register_id) }}" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-database"></i> Ver Registro
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
