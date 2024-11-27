@extends('adminlte::page')

@section('title', 'Detalle de la Alerta')

@section('content_header')
    <h1>Detalle de la Alerta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Alerta</h3>
            <div class="card-tools">
                <a href="{{ route('alerts.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('alerts.edit', $alert->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">ID:</dt>
                <dd class="col-sm-8">{{ $alert->id }}</dd>

                <dt class="col-sm-4">Sensor:</dt>
                <dd class="col-sm-8">
                    <a href="{{ route('sensors.show', $alert->sensor_id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-microchip"></i> {{ $alert->sensor->name }}
                    </a>
                </dd>

                <dt class="col-sm-4">Registro:</dt>
                <dd class="col-sm-8">
                    <a href="{{ route('registers.show', $alert->register_id) }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-database"></i> {{ $alert->register->value }}
                    </a>
                </dd>

                <dt class="col-sm-4">Revisada:</dt>
                <dd class="col-sm-8">{{ $alert->checked ? 'Sí' : 'No' }}</dd>

                <dt class="col-sm-4">Estado:</dt>
                <dd class="col-sm-8">{{ $alert->enable ? 'Activo' : 'Inactivo' }}</dd>

                <dt class="col-sm-4">Creado en:</dt>
                <dd class="col-sm-8">{{ $alert->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última actualización:</dt>
                <dd class="col-sm-8">{{ $alert->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
