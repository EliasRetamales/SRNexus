@extends('adminlte::page')

@section('title', 'Nuevo Límite Seguro')

@section('content_header')
    <h1>Crear Nuevo Límite Seguro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Registro de Límite Seguro</h3>
            <div class="card-tools">
                <a href="{{ route('safe_limits.index') }}" class="btn btn-secondary btn-sm">
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
            <form action="{{ route('safe_limits.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="max_value">Valor Máximo</label>
                    <input type="number" name="max_value" id="max_value" class="form-control" placeholder="Ingrese el valor máximo" value="{{ old('max_value') }}" step="0.01">
                </div>
                <div class="form-group">
                    <label for="min_value">Valor Mínimo</label>
                    <input type="number" name="min_value" id="min_value" class="form-control" placeholder="Ingrese el valor mínimo" value="{{ old('min_value') }}" step="0.01">
                </div>
                <div class="form-group">
                    <label for="enable">Estado</label>
                    <select name="enable" id="enable" class="form-control">
                        <option value="1" {{ old('enable') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('enable') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </form>
        </div>
    </div>
@stop
