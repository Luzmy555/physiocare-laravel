@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Crear Nuevo Fisioterapeuta</h1>

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
                    <form action="{{ route('fisioterapeutas.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="usuario_id" class="form-label">Usuario</label>
                            <select class="form-select @error('usuario_id') is-invalid @enderror" id="usuario_id" name="usuario_id" required>
                                <option value="">Seleccione un usuario</option>
                                @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nombre }} {{ $usuario->apellido }}
                                </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="especialidad_id" class="form-label">Especialidad</label>
                            <select class="form-select @error('especialidad_id') is-invalid @enderror" id="especialidad_id" name="especialidad_id" required>
                                <option value="">Seleccione una especialidad</option>
                                @foreach ($especialidades as $especialidad)
                                <option value="{{ $especialidad->id }}" {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                                    {{ $especialidad->nombre }}
                                </option>
                                @endforeach
                            </select>
                            @error('especialidad_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="numero_colegiatura" class="form-label">Número de Colegiatura</label>
                            <input type="text" class="form-control @error('numero_colegiatura') is-invalid @enderror"
                                id="numero_colegiatura" name="numero_colegiatura" value="{{ old('numero_colegiatura') }}" required>
                            @error('numero_colegiatura')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href="{{ route('fisioterapeutas.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
