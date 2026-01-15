@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalles de la Especialidad</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Información</h5>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $especialidad->id }}</p>
            <p><strong>Nombre:</strong> {{ $especialidad->nombre }}</p>
            <p><strong>Descripción:</strong></p>
            <p>{{ $especialidad->descripcion }}</p>
            <p><strong>Registrado:</strong> {{ $especialidad->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Fisioterapeutas ({{ $especialidad->fisioterapeutas->count() }})</h5>
        </div>
        <div class="card-body">
            @if ($especialidad->fisioterapeutas->count() > 0)
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Número Colegiatura</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($especialidad->fisioterapeutas as $fisiote)
                    <tr>
                        <td>{{ $fisiote->usuario->nombre ?? 'N/A' }} {{ $fisiote->usuario->apellido ?? '' }}</td>
                        <td>{{ $fisiote->usuario->email ?? 'N/A' }}</td>
                        <td>{{ $fisiote->numero_colegiatura }}</td>
                        <td>{{ $fisiote->usuario->telefono ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">No hay fisioterapeutas en esta especialidad</p>
            @endif
        </div>
    </div>
</div>
@endsection
