@extends('adminlte::page')

@section('title', 'Editar Proyecto')

@section('content_header')
    <h1>Editar Proyecto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición</h3>
            <div class="card-tools">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary btn-sm">
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
            <form action="{{ route('projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="client_id">Cliente</label>
                    <select name="client_id" id="client_id" class="form-control" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $client->id == $project->client_id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $project->name }}" required>
                </div>

                <div class="form-group">
                    <label for="code">Código</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ $project->code }}">
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control">{{ $project->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="enable">Habilitado</label>
                    <select name="enable" id="enable" class="form-control" required>
                        <option value="1" {{ $project->enable ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !$project->enable ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Actualizar Proyecto
                </button>
            </form>
        </div>
    </div>
@stop
