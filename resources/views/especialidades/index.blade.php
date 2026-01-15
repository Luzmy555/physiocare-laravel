@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Especialidades</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('especialidades.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Especialidad
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
                    <th>Fisioterapeutas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->id }}</td>
                    <td>{{ $especialidad->nombre }}</td>
                    <td>{{ Str::limit($especialidad->descripcion, 50) }}</td>
                    <td><span class="badge bg-info">{{ $especialidad->fisioterapeutas_count }}</span></td>
                    <td>
                        <a href="{{ route('especialidades.show', $especialidad->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('especialidades.destroy', $especialidad->id) }}" method="POST" class="d-inline">
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
                    <td colspan="5" class="text-center">No hay especialidades registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $especialidades->links() }}
    </div>
</div>
@endsection
