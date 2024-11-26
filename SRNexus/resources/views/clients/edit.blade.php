@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición</h3>
            <div class="card-tools">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-sm">
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
            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre del Cliente</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="activity">Actividad</label>
                    <input type="text" name="activity" id="activity" class="form-control" value="{{ old('activity', $client->activity) }}" required>
                </div>

                <div class="form-group">
                    <label for="rut">RUT</label>
                    <input type="text" name="rut" id="rut" class="form-control" value="{{ old('rut', $client->rut) }}" required>
                </div>

                <div class="form-group">
                    <label for="enable">Estado</label>
                    <select name="enable" id="enable" class="form-control">
                        <option value="1" {{ old('enable', $client->enable) == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('enable', $client->enable) == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </div>
@stop
