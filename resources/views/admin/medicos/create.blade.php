@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 80px auto;">
    <h1>➕ Crear Médico (Admin)</h1>

    <form action="{{ route('admin.medicos.store') }}" method="POST">
        @csrf

    @if(session('success'))
        <div style="background:#dcfce7; border:1px solid #bbf7d0; padding:.75rem; margin: .75rem 0; border-radius:6px; color:#065f46;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#fff1f2; border:1px solid #fecaca; padding:.75rem; margin: .75rem 0; border-radius:6px; color:#991b1b;">
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div style="margin-bottom: 1rem;">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required style="width:100%; padding: .5rem;">
            @error('nombre') <div style="color:#b91c1c; margin-top:.25rem;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label>Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" required style="width:100%; padding: .5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label>Email</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required style="width:100%; padding: .5rem;">
            @error('correo') <div style="color:#b91c1c; margin-top:.25rem;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" required style="width:100%; padding: .5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label>Especialidad</label>
            <select name="especialidad_id" required style="width:100%; padding: .5rem;">
                <option value="">-- Seleccionar --</option>
                @foreach($especialidades as $esp)
                    <option value="{{ $esp->id }}">{{ $esp->nombre }}</option>
                @endforeach
            </select>
            @error('especialidad_id') <div style="color:#b91c1c; margin-top:.25rem;">{{ $message }}</div> @enderror
        </div>


        <div style="margin-bottom: 1rem;">
            <label>Número de Colegiado</label>
            <input type="text" name="numero_colegiado" value="{{ old('numero_colegiado') }}" required style="width:100%; padding: .5rem;">
            @error('numero_colegiado') <div style="color:#b91c1c; margin-top:.25rem;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 1rem; display: flex; gap: 1rem;">
            <div style="flex:1;">
                <label>Horario Inicio</label>
                <input type="time" name="horario_inicio" value="{{ old('horario_inicio') }}" style="width:100%; padding: .5rem;">
                @error('horario_inicio') <div style="color:#b91c1c; margin-top:.25rem;">{{ $message }}</div> @enderror
            </div>
            <div style="flex:1;">
                <label>Horario Fin</label>
                <input type="time" name="horario_fin" value="{{ old('horario_fin') }}" style="width:100%; padding: .5rem;">
                @error('horario_fin') <div style="color:#b91c1c; margin-top:.25rem;">{{ $message }}</div> @enderror
            </div>
        </div>

        <div style="display:flex; gap: .5rem;">
            <a href="{{ route('admin.medicos.index') }}" class="btn" style="padding: .5rem 1rem; background:#e5e7eb;">Cancelar</a>
            <button type="submit" style="padding: .5rem 1rem; background:#0066cc; color:white; border:none;">Crear Médico</button>
        </div>
    </form>
</div>
@endsection
