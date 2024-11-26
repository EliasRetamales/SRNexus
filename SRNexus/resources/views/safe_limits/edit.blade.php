@extends('adminlte::page')

@section('title', 'Editar Límite Seguro')

@section('content_header')
    <h1>Editar Límite Seguro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición</h3>
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
            <form action="{{ route('safe_limits.update', $safeLimit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="max_value">Valor Máximo</label>
                    <input type="number" step="0.01" name="max_value" id="max_value" class="form-control"
                        value="{{ old('max_value', $safeLimit->max_value) }}" placeholder="Ingrese el valor máximo">
                </div>

                <div class="form-group">
                    <label for="min_value">Valor Mínimo</label>
                    <input type="number" step="0.01" name="min_value" id="min_value" class="form-control"
                        value="{{ old('min_value', $safeLimit->min_value) }}" placeholder="Ingrese el valor mínimo">
                </div>

                <div class="form-group">
                    <label for="enable">Estado</label>
                    <select name="enable" id="enable" class="form-control">
                        <option value="1" {{ old('enable', $safeLimit->enable) == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('enable', $safeLimit->enable) == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </div>
@stop
