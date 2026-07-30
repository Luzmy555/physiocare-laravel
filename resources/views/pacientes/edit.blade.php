<x-layouts.internal :title="'Editar Paciente - FisioCare Ayla'">
    <x-ui.page-header title="Editar Paciente" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input type="text" name="nombre" label="Nombre" :value="old('nombre', $paciente->nombre)" required />
                <x-ui.input type="text" name="apellido" label="Apellido" :value="old('apellido', $paciente->apellido)" />
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input type="text" name="cedula" label="Cédula" :value="old('cedula', $paciente->cedula)" />
                <x-ui.input type="email" name="correo" label="Correo" :value="old('correo', $paciente->correo)" />
            </div>

            <x-ui.input type="date" name="fecha_nacimiento" label="Fecha de Nacimiento" :value="old('fecha_nacimiento', $paciente->fecha_nacimiento)" required />
            <x-ui.input type="text" name="direccion" label="Dirección" :value="old('direccion', $paciente->direccion)" required />
            <x-ui.input type="text" name="telefono" label="Teléfono" :value="old('telefono', $paciente->telefono)" required />

            <x-ui.select name="sexo" label="Sexo" required>
                <option value="">Seleccione</option>
                <option value="M" {{ $paciente->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ $paciente->sexo == 'F' ? 'selected' : '' }}>Femenino</option>
            </x-ui.select>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Actualizar</x-ui.button>
                <x-ui.button :href="route('pacientes.show', $paciente->id)" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
