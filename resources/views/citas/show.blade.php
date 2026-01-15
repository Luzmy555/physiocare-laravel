@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalles de la Cita</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Información de la Cita</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $cita->id }}</p>
                    <p><strong>Paciente:</strong> {{ $cita->paciente->usuario->nombre ?? 'N/A' }} {{ $cita->paciente->usuario->apellido ?? '' }}</p>
                    <p><strong>Email Paciente:</strong> {{ $cita->paciente->usuario->email ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $cita->paciente->usuario->telefono ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fisioterapeuta:</strong> {{ $cita->fisioterapeuta->usuario->nombre ?? 'N/A' }} {{ $cita->fisioterapeuta->usuario->apellido ?? '' }}</p>
                    <p><strong>Especialidad:</strong> {{ $cita->fisioterapeuta->especialidad->nombre ?? 'N/A' }}</p>
                    <p><strong>Número Colegiatura:</strong> {{ $cita->fisioterapeuta->numero_colegiatura }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fecha:</strong> {{ $cita->fecha_cita }}</p>
                    <p><strong>Hora:</strong> {{ $cita->hora_cita }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Estado:</strong>
                        @if ($cita->estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                        @elseif ($cita->estado == 'completada')
                            <span class="badge bg-success">Completada</span>
                        @else
                            <span class="badge bg-danger">Cancelada</span>
                        @endif
                    </p>
                </div>
            </div>
            <hr>
            <p><strong>Motivo:</strong></p>
            <p>{{ $cita->motivo }}</p>
            <p><strong>Registrada:</strong> {{ $cita->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>
@endsection
