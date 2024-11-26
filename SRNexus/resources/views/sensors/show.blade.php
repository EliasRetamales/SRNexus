@extends('adminlte::page')

@section('title', 'Detalle del Sensor')

@section('content_header')
    <h1>Detalle del Sensor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Sensor</h3>
            <div class="card-tools">
                <a href="{{ route('sensors.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('sensors.edit', $sensor->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Proyecto:</dt>
                <dd class="col-sm-8">{{ $sensor->project->name }}</dd>

                <dt class="col-sm-4">Límite Seguro:</dt>
                <dd class="col-sm-8">
                    @if ($sensor->safeLimit)
                        Max: {{ $sensor->safeLimit->max_value }}, Min: {{ $sensor->safeLimit->min_value }}
                    @else
                        Sin Límite Seguro
                    @endif
                </dd>

                <dt class="col-sm-4">Nombre del Sensor:</dt>
                <dd class="col-sm-8">{{ $sensor->name }}</dd>

                <dt class="col-sm-4">Rango Máximo:</dt>
                <dd class="col-sm-8">{{ $sensor->range_max }}</dd>

                <dt class="col-sm-4">Rango Mínimo:</dt>
                <dd class="col-sm-8">{{ $sensor->range_min }}</dd>

                <dt class="col-sm-4">Error (%):</dt>
                <dd class="col-sm-8">{{ $sensor->error }}</dd>

                <dt class="col-sm-4">Sensibilidad:</dt>
                <dd class="col-sm-8">{{ $sensor->sensitivity ?? 'No especificada' }}</dd>

                <dt class="col-sm-4">Estado:</dt>
                <dd class="col-sm-8">
                    <span class="badge {{ $sensor->enable ? 'badge-success' : 'badge-danger' }}">
                        {{ $sensor->enable ? 'Activo' : 'Inactivo' }}
                    </span>
                </dd>

                <dt class="col-sm-4">Fecha de Creación:</dt>
                <dd class="col-sm-8">{{ $sensor->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última Actualización:</dt>
                <dd class="col-sm-8">{{ $sensor->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
