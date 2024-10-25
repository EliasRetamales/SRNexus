@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
    <h1>Detalles del Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>{{ $user->name }}</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Roles:</strong>
                @foreach($user->roles as $role)
                    <span class="badge badge-primary">{{ $role->name }}</span>
                @endforeach
            </p>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
