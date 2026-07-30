<x-layouts.internal :title="'Editar Médico - FisioCare Ayla'">
    <x-ui.page-header title="Editar Fisioterapeuta" :subtitle="$medico->nombre . ' ' . $medico->apellido" />

    <x-ui.card class="mx-auto max-w-2xl">
        @if(session('success'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.medicos.update', $medico->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input type="text" name="nombre" label="Nombre" :value="old('nombre', $medico->nombre)" required />
                <x-ui.input type="text" name="apellido" label="Apellido" :value="old('apellido', $medico->apellido)" required />
            </div>

            <x-ui.input type="email" name="correo" label="Email" :value="old('correo', $medico->correo)" required />
            <x-ui.input type="text" name="telefono" label="Teléfono" :value="old('telefono', $medico->telefono)" required />

            <x-ui.select name="especialidad_id" label="Especialidad" required>
                <option value="">-- Seleccionar --</option>
                @foreach($especialidades as $esp)
                    <option value="{{ $esp->id }}" {{ $medico->especialidad_id == $esp->id ? 'selected' : '' }}>{{ $esp->nombre }}</option>
                @endforeach
            </x-ui.select>

            <x-ui.input type="text" name="numero_colegiado" label="Número de Colegiado" :value="old('numero_colegiado', $medico->numero_colegiado ?? '')" required />

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input type="time" name="horario_inicio" label="Horario Inicio" :value="old('horario_inicio', $medico->horario_inicio ?? '')" />
                <x-ui.input type="time" name="horario_fin" label="Horario Fin" :value="old('horario_fin', $medico->horario_fin ?? '')" />
            </div>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Guardar Cambios</x-ui.button>
                <x-ui.button :href="route('admin.medicos.index')" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
