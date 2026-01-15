@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalles del Paciente</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Información del Paciente</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $paciente->id }}</p>
                    <p><strong>Usuario:</strong> {{ $paciente->usuario->nombre ?? 'N/A' }} {{ $paciente->usuario->apellido ?? '' }}</p>
                    <p><strong>Email:</strong> {{ $paciente->usuario->email ?? 'N/A' }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ $paciente->fecha_nacimiento }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Dirección:</strong> {{ $paciente->direccion }}</p>
                    <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
                    <p><strong>Sexo:</strong> {{ $paciente->sexo == 'M' ? 'Masculino' : 'Femenino' }}</p>
                    <p><strong>Registrado:</strong> {{ $paciente->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Citas ({{ $paciente->citas->count() }})</h5>
        </div>
        <div class="card-body">
            @if ($paciente->citas->count() > 0)
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Fisioterapeuta</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paciente->citas as $cita)
                    <tr>
                        <td>{{ $cita->fecha_cita }}</td>
                        <td>{{ $cita->hora_cita }}</td>
                        <td>{{ $cita->fisioterapeuta->usuario->nombre ?? 'N/A' }}</td>
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

    <div class="card">
        <div class="card-header">
            <h5>Historiales Clínicos ({{ $paciente->historiales->count() }})</h5>
        </div>
        <div class="card-body">
            @if ($paciente->historiales->count() > 0)
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Fisioterapeuta</th>
                        <th>Diagnóstico</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paciente->historiales as $historial)
                    <tr>
                        <td>{{ $historial->created_at->format('d/m/Y') }}</td>
                        <td>{{ $historial->fisioterapeuta->usuario->nombre ?? 'N/A' }}</td>
                        <td>{{ $historial->diagnostico }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">No hay historiales clínicos registrados</p>
            @endif
        </div>
    </div>
</div>
@endsection
