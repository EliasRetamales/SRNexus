@extends('adminlte::page')

@section('title', 'Crear Estadística')

@section('content_header')
    <h1>Crear Nueva Estadística</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario para Crear Estadística</h3>
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

            <form action="{{ route('stadistics.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="sensor_id">Sensor</label>
                    <select name="sensor_id" id="sensor_id" class="form-control" required>
                        <option value="">Seleccione un sensor</option>
                        @foreach ($sensors as $sensor)
                            <option value="{{ $sensor->id }}">{{ $sensor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="avg">Promedio</label>
                    <input type="number" step="0.01" name="avg" id="avg" class="form-control" placeholder="Ingrese el promedio" required>
                </div>

                <div class="form-group">
                    <label for="max">Máximo</label>
                    <input type="number" step="0.01" name="max" id="max" class="form-control" placeholder="Ingrese el máximo" required>
                </div>

                <div class="form-group">
                    <label for="min">Mínimo</label>
                    <input type="number" step="0.01" name="min" id="min" class="form-control" placeholder="Ingrese el mínimo" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('stadistics.index') }}" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
