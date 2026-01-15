@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Historiales Clínicos</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('historiales.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Historial
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
                    <th>Paciente</th>
                    <th>Fisioterapeuta</th>
                    <th>Diagnóstico</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($historiales as $historial)
                <tr>
                    <td>{{ $historial->id }}</td>
                    <td>{{ $historial->paciente->usuario->nombre ?? 'N/A' }}</td>
                    <td>{{ $historial->fisioterapeuta->usuario->nombre ?? 'N/A' }}</td>
                    <td>{{ Str::limit($historial->diagnostico, 50) }}</td>
                    <td>{{ $historial->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('historiales.show', $historial->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('historiales.edit', $historial->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('historiales.destroy', $historial->id) }}" method="POST" class="d-inline">
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
                    <td colspan="6" class="text-center">No hay historiales registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $historiales->links() }}
    </div>
</div>
@endsection
