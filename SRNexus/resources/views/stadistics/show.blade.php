@extends('adminlte::page')

@section('title', 'Detalle de Estadística')

@section('content_header')
    <h1>Detalle de Estadística</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Estadística</h3>
            <div class="card-tools">
                <a href="{{ route('stadistics.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $stadistic->id }}</td>
                </tr>
                <tr>
                    <th>Sensor</th>
                    <td>{{ $stadistic->sensor->name }}</td>
                </tr>
                <tr>
                    <th>Promedio (AVG)</th>
                    <td>{{ $stadistic->avg }}</td>
                </tr>
                <tr>
                    <th>Máximo (MAX)</th>
                    <td>{{ $stadistic->max }}</td>
                </tr>
                <tr>
                    <th>Mínimo (MIN)</th>
                    <td>{{ $stadistic->min }}</td>
                </tr>
                <tr>
                    <th>Fecha de Creación</th>
                    <td>{{ $stadistic->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Última Actualización</th>
                    <td>{{ $stadistic->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
