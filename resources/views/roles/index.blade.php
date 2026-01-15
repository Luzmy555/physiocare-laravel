@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Roles</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Rol
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Usuarios</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $rol)
                <tr>
                    <td>{{ $rol->id }}</td>
                    <td>{{ $rol->nombre_rol }}</td>
                    <td>{{ Str::limit($rol->descripcion, 50) }}</td>
                    <td><span class="badge bg-info">{{ $rol->usuarios_count }}</span></td>
                    <td>
                        <a href="{{ route('roles.show', $rol->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay roles registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $roles->links() }}
    </div>
</div>
@endsection
