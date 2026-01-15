@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalles del Historial Clínico</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('historiales.edit', $historial->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('historiales.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Información del Historial</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $historial->id }}</p>
                    <p><strong>Paciente:</strong> {{ $historial->paciente->usuario->nombre ?? 'N/A' }} {{ $historial->paciente->usuario->apellido ?? '' }}</p>
                    <p><strong>Email Paciente:</strong> {{ $historial->paciente->usuario->email ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fisioterapeuta:</strong> {{ $historial->fisioterapeuta->usuario->nombre ?? 'N/A' }} {{ $historial->fisioterapeuta->usuario->apellido ?? '' }}</p>
                    <p><strong>Especialidad:</strong> {{ $historial->fisioterapeuta->especialidad->nombre ?? 'N/A' }}</p>
                    <p><strong>Registrado:</strong> {{ $historial->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <hr>
            <p><strong>Descripción:</strong></p>
            <p>{{ $historial->descripcion }}</p>
            <hr>
            <p><strong>Diagnóstico:</strong></p>
            <p>{{ $historial->diagnostico }}</p>
            <hr>
            <p><strong>Tratamiento:</strong></p>
            <p>{{ $historial->tratamiento }}</p>
        </div>
    </div>
</div>
@endsection
