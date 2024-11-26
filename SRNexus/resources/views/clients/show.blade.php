@extends('adminlte::page')

@section('title', 'Detalle del Usuario')

@section('content_header')
    <h1>Detalle del Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Usuario</h3>
            <div class="card-tools">
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                </a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nombre:</dt>
                <dd class="col-sm-8">{{ $user->name }}</dd>

                <dt class="col-sm-4">Email:</dt>
                <dd class="col-sm-8">{{ $user->email }}</dd>

                <dt class="col-sm-4">Rol:</dt>
                <dd class="col-sm-8">{{ $user->roles->pluck('name')->join(', ') }}</dd>

                <dt class="col-sm-4">Estado:</dt>
                <dd class="col-sm-8">
                    <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </dd>
            </dl>
        </div>
    </div>
@stop
