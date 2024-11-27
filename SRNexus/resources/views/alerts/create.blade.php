@extends('adminlte::page')

@section('title', 'Nueva Alerta')

@section('content_header')
    <h1>Crear Nueva Alerta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Registro de Alerta</h3>
            <div class="card-tools">
                <a href="{{ route('alerts.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('alerts.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="sensor_id">Sensor</label>
                    <select name="sensor_id" id="sensor_id" class="form-control" required>
                        @foreach ($sensors as $sensor)
                            <option value="{{ $sensor->id }}">{{ $sensor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="register_id">Registro</label>
                    <select name="register_id" id="register_id" class="form-control" required>
                        @foreach ($registers as $register)
                            <option value="{{ $register->id }}">{{ $register->value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="checked">Revisada</label>
                    <select name="checked" id="checked" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="enable">Estado</label>
                    <select name="enable" id="enable" class="form-control">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </form>
        </div>
    </div>
@stop
