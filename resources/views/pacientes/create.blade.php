<x-layouts.internal :title="'Nuevo Paciente - FisioCare Ayla'">
    <x-ui.page-header title="Crear Nuevo Paciente" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('pacientes.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input type="text" name="nombre" label="Nombre" :value="old('nombre')" required />
                <x-ui.input type="text" name="apellido" label="Apellido" :value="old('apellido')" />
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input type="text" name="cedula" label="Cédula" :value="old('cedula')" />
                <x-ui.input type="email" name="correo" label="Correo" :value="old('correo')" />
            </div>

            <x-ui.input type="date" name="fecha_nacimiento" label="Fecha de Nacimiento" :value="old('fecha_nacimiento')" required />
            <x-ui.input type="text" name="direccion" label="Dirección" :value="old('direccion')" required />
            <x-ui.input type="text" name="telefono" label="Teléfono" :value="old('telefono')" required />

            <x-ui.select name="sexo" label="Sexo" required>
                <option value="">Seleccione</option>
                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
            </x-ui.select>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Guardar</x-ui.button>
                <x-ui.button :href="route('pacientes.index')" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
