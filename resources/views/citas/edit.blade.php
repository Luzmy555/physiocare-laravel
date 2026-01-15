@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Editar Cita</h1>

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Errores:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('citas.update', $cita->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="paciente_id" class="form-label">Paciente</label>
                            <select class="form-select @error('paciente_id') is-invalid @enderror" id="paciente_id" name="paciente_id" required>
                                <option value="">Seleccione un paciente</option>
                                @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ $cita->paciente_id == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->usuario->nombre ?? 'N/A' }}
                                </option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fisioterapeuta_id" class="form-label">Fisioterapeuta</label>
                            <select class="form-select @error('fisioterapeuta_id') is-invalid @enderror" id="fisioterapeuta_id" name="fisioterapeuta_id" required>
                                <option value="">Seleccione un fisioterapeuta</option>
                                @foreach ($fisioterapeutas as $fisioterapeuta)
                                <option value="{{ $fisioterapeuta->id }}" {{ $cita->fisioterapeuta_id == $fisioterapeuta->id ? 'selected' : '' }}>
                                    {{ $fisioterapeuta->usuario->nombre ?? 'N/A' }}
                                </option>
                                @endforeach
                            </select>
                            @error('fisioterapeuta_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha_cita" class="form-label">Fecha</label>
                            <input type="date" class="form-control @error('fecha_cita') is-invalid @enderror"
                                id="fecha_cita" name="fecha_cita" value="{{ $cita->fecha_cita }}" required>
                            @error('fecha_cita')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hora_cita" class="form-label">Hora</label>
                            <input type="time" class="form-control @error('hora_cita') is-invalid @enderror"
                                id="hora_cita" name="hora_cita" value="{{ $cita->hora_cita }}" required>
                            @error('hora_cita')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo</label>
                            <textarea class="form-control @error('motivo') is-invalid @enderror"
                                id="motivo" name="motivo" rows="3" required>{{ $cita->motivo }}</textarea>
                            @error('motivo')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="">Seleccione</option>
                                <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="completada" {{ $cita->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('estado')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <a href="{{ route('citas.show', $cita->id) }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
