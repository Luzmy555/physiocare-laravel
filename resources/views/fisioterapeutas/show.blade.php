@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalles del Fisioterapeuta</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('fisioterapeutas.edit', $fisioterapeuta->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('fisioterapeutas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Información del Fisioterapeuta</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $fisioterapeuta->id }}</p>
                    <p><strong>Nombre:</strong> {{ $fisioterapeuta->usuario->nombre ?? 'N/A' }} {{ $fisioterapeuta->usuario->apellido ?? '' }}</p>
                    <p><strong>Email:</strong> {{ $fisioterapeuta->usuario->email ?? 'N/A' }}</p>
                    <p><strong>Especialidad:</strong> {{ $fisioterapeuta->especialidad->nombre ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Número Colegiatura:</strong> {{ $fisioterapeuta->numero_colegiatura }}</p>
                    <p><strong>Teléfono:</strong> {{ $fisioterapeuta->usuario->telefono ?? 'N/A' }}</p>
                    <p><strong>Registrado:</strong> {{ $fisioterapeuta->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Citas ({{ $fisioterapeuta->citas->count() }})</h5>
        </div>
        <div class="card-body">
            @if ($fisioterapeuta->citas->count() > 0)
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fisioterapeuta->citas as $cita)
                    <tr>
                        <td>{{ $cita->fecha_cita }}</td>
                        <td>{{ $cita->hora_cita }}</td>
                        <td>{{ $cita->paciente->usuario->nombre ?? 'N/A' }}</td>
                        <td>{{ $cita->motivo }}</td>
                        <td><span class="badge bg-secondary">{{ $cita->estado }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">No hay citas registradas</p>
            @endif
        </div>
    </div>
</div>
@endsection
