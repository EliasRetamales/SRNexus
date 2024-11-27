@extends('adminlte::page')

@section('title', 'Detalle de Conexión a InfluxDB')

@section('content_header')
    <h1>Detalle de Conexión a InfluxDB</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Conexión</h3>
            <div class="card-tools">
                <a href="{{ route('influxdb_connections.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('influxdb_connections.edit', $influxdbConnection->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Proyecto Asociado:</dt>
                <dd class="col-sm-8">{{ $influxdbConnection->project->name }}</dd>

                <dt class="col-sm-4">Nombre:</dt>
                <dd class="col-sm-8">{{ $influxdbConnection->name }}</dd>

                <dt class="col-sm-4">URL:</dt>
                <dd class="col-sm-8">{{ $influxdbConnection->url }}</dd>

                <dt class="col-sm-4">Token:</dt>
                <dd class="col-sm-8">
                    <textarea class="form-control" readonly>{{ $influxdbConnection->token }}</textarea>
                </dd>

                <dt class="col-sm-4">Bucket:</dt>
                <dd class="col-sm-8">{{ $influxdbConnection->bucket }}</dd>

                <dt class="col-sm-4">Organización:</dt>
                <dd class="col-sm-8">{{ $influxdbConnection->organization }}</dd>

                <dt class="col-sm-4">Fecha de Creación:</dt>
                <dd class="col-sm-8">{{ $influxdbConnection->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última Actualización:</dt>
                <dd class="col-sm-8">{{ $influxdbConnection->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
