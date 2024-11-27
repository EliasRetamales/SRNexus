@extends('adminlte::page')

@section('title', 'Detalle del Registro')

@section('content_header')
    <h1>Detalle del Registro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Registro</h3>
            <div class="card-tools">
                <a href="{{ route('registers.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('registers.edit', $register->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Valor:</dt>
                <dd class="col-sm-8">{{ $register->value }}</dd>

                <dt class="col-sm-4">Fecha de Medición:</dt>
                <dd class="col-sm-8">{{ $register->measurement_time->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Estado:</dt>
                <dd class="col-sm-8">
                    <span class="badge {{ $register->enable ? 'badge-success' : 'badge-danger' }}">
                        {{ $register->enable ? 'Activo' : 'Inactivo' }}
                    </span>
                </dd>

                <dt class="col-sm-4">Fecha de Creación:</dt>
                <dd class="col-sm-8">{{ $register->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última Actualización:</dt>
                <dd class="col-sm-8">{{ $register->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
