@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalles del Usuario</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Información del Usuario</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $usuario->id }}</p>
                    <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
                    <p><strong>Email:</strong> {{ $usuario->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Rol:</strong> <span class="badge bg-primary">{{ $usuario->rol->nombre_rol ?? 'Sin rol' }}</span></p>
                    <p><strong>Registrado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de fisioterapeuta eliminada para User --}}
</div>
@endsection
