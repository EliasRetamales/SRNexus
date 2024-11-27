@extends('adminlte::page')

@section('title', 'Editar Registro')

@section('content_header')
    <h1>Editar Registro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición</h3>
            <div class="card-tools">
                <a href="{{ route('registers.index') }}" class="btn btn-secondary btn-sm">
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
            <form action="{{ route('registers.update', $register->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="value">Valor</label>
                    <input type="text" name="value" id="value" class="form-control" value="{{ old('value', $register->value) }}" required>
                </div>

                <div class="form-group">
                    <label for="measurement_time">Fecha de Medición</label>
                    <input type="datetime-local" name="measurement_time" id="measurement_time" class="form-control"
                        value="{{ old('measurement_time', $register->measurement_time->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="form-group">
                    <label for="enable">Estado</label>
                    <select name="enable" id="enable" class="form-control">
                        <option value="1" {{ old('enable', $register->enable) == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('enable', $register->enable) == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </div>
@stop