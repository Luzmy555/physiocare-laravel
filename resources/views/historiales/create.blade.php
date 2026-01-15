@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Crear Nuevo Historial Clínico</h1>

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
                    <form action="{{ route('historiales.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="paciente_id" class="form-label">Paciente</label>
                            <select class="form-select @error('paciente_id') is-invalid @enderror" id="paciente_id" name="paciente_id" required>
                                <option value="">Seleccione un paciente</option>
                                @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
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
                                <option value="{{ $fisioterapeuta->id }}" {{ old('fisioterapeuta_id') == $fisioterapeuta->id ? 'selected' : '' }}>
                                    {{ $fisioterapeuta->usuario->nombre ?? 'N/A' }}
                                </option>
                                @endforeach
                            </select>
                            @error('fisioterapeuta_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="diagnostico" class="form-label">Diagnóstico</label>
                            <textarea class="form-control @error('diagnostico') is-invalid @enderror"
                                id="diagnostico" name="diagnostico" rows="3" required>{{ old('diagnostico') }}</textarea>
                            @error('diagnostico')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tratamiento" class="form-label">Tratamiento</label>
                            <textarea class="form-control @error('tratamiento') is-invalid @enderror"
                                id="tratamiento" name="tratamiento" rows="3" required>{{ old('tratamiento') }}</textarea>
                            @error('tratamiento')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href="{{ route('historiales.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
