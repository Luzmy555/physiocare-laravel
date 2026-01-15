@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Fisioterapeutas</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('fisioterapeutas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Fisioterapeuta
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
                    <th>Especialidad</th>
                    <th>Número Colegiatura</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fisioterapeutas as $fisioterapeuta)
                <tr>
                    <td>{{ $fisioterapeuta->id }}</td>
                    <td>{{ $fisioterapeuta->usuario->nombre ?? 'N/A' }} {{ $fisioterapeuta->usuario->apellido ?? '' }}</td>
                    <td>{{ $fisioterapeuta->especialidad->nombre ?? 'N/A' }}</td>
                    <td>{{ $fisioterapeuta->numero_colegiatura }}</td>
                    <td>{{ $fisioterapeuta->usuario->telefono ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('fisioterapeutas.show', $fisioterapeuta->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('fisioterapeutas.edit', $fisioterapeuta->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('fisioterapeutas.destroy', $fisioterapeuta->id) }}" method="POST" class="d-inline">
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
                    <td colspan="6" class="text-center">No hay fisioterapeutas registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $fisioterapeutas->links() }}
    </div>
</div>
@endsection
