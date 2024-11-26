@extends('adminlte::page')

@section('title', 'Editar Sensor')

@section('content_header')
    <h1>Editar Sensor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición</h3>
            <div class="card-tools">
                <a href="{{ route('sensors.index') }}" class="btn btn-secondary btn-sm">
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
            <form action="{{ route('sensors.update', $sensor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="project_id">Proyecto</label>
                    <select name="project_id" id="project_id" class="form-control" required>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id', $sensor->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="safe_limit_id">Límite Seguro (Opcional)</label>
                    <select name="safe_limit_id" id="safe_limit_id" class="form-control">
                        <option value="">Sin Límite Seguro</option>
                        @foreach ($safeLimits as $safeLimit)
                            <option value="{{ $safeLimit->id }}" {{ old('safe_limit_id', $sensor->safe_limit_id) == $safeLimit->id ? 'selected' : '' }}>
                                Max: {{ $safeLimit->max_value }}, Min: {{ $safeLimit->min_value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Nombre del Sensor</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $sensor->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="range_max">Rango Máximo</label>
                    <input type="number" step="any" name="range_max" id="range_max" class="form-control" value="{{ old('range_max', $sensor->range_max) }}" required>
                </div>

                <div class="form-group">
                    <label for="range_min">Rango Mínimo</label>
                    <input type="number" step="any" name="range_min" id="range_min" class="form-control" value="{{ old('range_min', $sensor->range_min) }}" required>
                </div>

                <div class="form-group">
                    <label for="error">Error (%)</label>
                    <input type="number" step="any" name="error" id="error" class="form-control" value="{{ old('error', $sensor->error) }}" required>
                </div>

                <div class="form-group">
                    <label for="sensitivity">Sensibilidad (Opcional)</label>
                    <input type="text" name="sensitivity" id="sensitivity" class="form-control" value="{{ old('sensitivity', $sensor->sensitivity) }}">
                </div>

                <div class="form-group">
                    <label for="enable">Estado</label>
                    <select name="enable" id="enable" class="form-control" required>
                        <option value="1" {{ old('enable', $sensor->enable) == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('enable', $sensor->enable) == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </div>
@stop
