@extends('adminlte::page')

@section('title', 'Detalle del Cliente')

@section('content_header')
    <h1>Detalle del Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Cliente</h3>
            <div class="card-tools">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nombre del Cliente:</dt>
                <dd class="col-sm-8">{{ $client->name }}</dd>

                <dt class="col-sm-4">Actividad:</dt>
                <dd class="col-sm-8">{{ $client->activity }}</dd>

                <dt class="col-sm-4">RUT:</dt>
                <dd class="col-sm-8">{{ $client->rut }}</dd>

                <dt class="col-sm-4">Estado:</dt>
                <dd class="col-sm-8">
                    <span class="badge {{ $client->enable ? 'badge-success' : 'badge-danger' }}">
                        {{ $client->enable ? 'Activo' : 'Inactivo' }}
                    </span>
                </dd>

                <dt class="col-sm-4">Fecha de Creación:</dt>
                <dd class="col-sm-8">{{ $client->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última Actualización:</dt>
                <dd class="col-sm-8">{{ $client->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
