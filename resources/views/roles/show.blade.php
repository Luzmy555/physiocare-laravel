@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalles del Rol</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Información del Rol</h5>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $rol->id }}</p>
            <p><strong>Nombre:</strong> {{ $rol->nombre_rol }}</p>
            <p><strong>Descripción:</strong></p>
            <p>{{ $rol->descripcion }}</p>
            <p><strong>Registrado:</strong> {{ $rol->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Usuarios Asignados ({{ $rol->usuarios->count() }})</h5>
        </div>
        <div class="card-body">
            @if ($rol->usuarios->count() > 0)
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Registrado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rol->usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->telefono }}</td>
                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">No hay usuarios asignados a este rol</p>
            @endif
        </div>
    </div>
</div>
@endsection
