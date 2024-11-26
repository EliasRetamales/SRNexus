@extends('adminlte::page')

@section('title', 'Nuevo Cliente')

@section('content_header')
    <h1>Crear Nuevo Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Registro de Cliente</h3>
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
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre del Cliente</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese el nombre del cliente" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="activity">Actividad</label>
                    <input type="text" name="activity" id="activity" class="form-control" placeholder="Ingrese la actividad del cliente" value="{{ old('activity') }}" required>
                </div>
                <div class="form-group">
                    <label for="rut">RUT</label>
                    <input type="text" name="rut" id="rut" class="form-control" placeholder="Ingrese el RUT del cliente (e.g., 12345678-9)" value="{{ old('rut') }}" required>
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
