@extends('adminlte::page')

@section('title', 'Detalle del Límite Seguro')

@section('content_header')
    <h1>Detalle del Límite Seguro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Límite Seguro</h3>
            <div class="card-tools">
                <a href="{{ route('safe_limits.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('safe_limits.edit', $safeLimit->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Valor Máximo:</dt>
                <dd class="col-sm-8">{{ $safeLimit->max_value ?? 'No definido' }}</dd>

                <dt class="col-sm-4">Valor Mínimo:</dt>
                <dd class="col-sm-8">{{ $safeLimit->min_value ?? 'No definido' }}</dd>

                <dt class="col-sm-4">Estado:</dt>
                <dd class="col-sm-8">
                    <span class="badge {{ $safeLimit->enable ? 'badge-success' : 'badge-danger' }}">
                        {{ $safeLimit->enable ? 'Activo' : 'Inactivo' }}
                    </span>
                </dd>

                <dt class="col-sm-4">Fecha de Creación:</dt>
                <dd class="col-sm-8">{{ $safeLimit->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última Actualización:</dt>
                <dd class="col-sm-8">{{ $safeLimit->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
