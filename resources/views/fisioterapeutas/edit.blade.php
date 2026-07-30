<x-layouts.internal :title="'Editar Fisioterapeuta - FisioCare Ayla'">
    <x-ui.page-header title="Editar Fisioterapeuta" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('fisioterapeutas.update', $fisioterapeuta->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <x-ui.select name="usuario_id" label="Usuario" required>
                <option value="">Seleccione un usuario</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $fisioterapeuta->usuario_id == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }} {{ $usuario->apellido }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.select name="especialidad_id" label="Especialidad" required>
                <option value="">Seleccione una especialidad</option>
                @foreach ($especialidades as $especialidad)
                    <option value="{{ $especialidad->id }}" {{ $fisioterapeuta->especialidad_id == $especialidad->id ? 'selected' : '' }}>
                        {{ $especialidad->nombre }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.input type="text" name="numero_colegiatura" label="Número de Colegiatura" :value="$fisioterapeuta->numero_colegiatura" required />

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Actualizar</x-ui.button>
                <x-ui.button :href="route('fisioterapeutas.show', $fisioterapeuta->id)" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
