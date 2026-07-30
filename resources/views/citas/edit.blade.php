<x-layouts.internal :title="'Editar Cita - FisioCare Ayla'">
    <x-ui.page-header title="Editar Cita" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <x-ui.select name="paciente_id" label="Paciente" required>
                <option value="">Seleccione un paciente</option>
                @foreach ($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ $cita->paciente_id == $paciente->id ? 'selected' : '' }}>
                        {{ $paciente->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.select name="fisioterapeuta_id" label="Fisioterapeuta" required>
                <option value="">Seleccione un fisioterapeuta</option>
                @foreach ($fisioterapeutas as $fisioterapeuta)
                    <option value="{{ $fisioterapeuta->id }}" {{ $cita->fisioterapeuta_id == $fisioterapeuta->id ? 'selected' : '' }}>
                        {{ $fisioterapeuta->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.select name="especialidad_id" label="Especialidad" required>
                <option value="">Seleccione una especialidad</option>
                @foreach ($especialidades as $especialidad)
                    <option value="{{ $especialidad->id }}" {{ $cita->especialidad_id == $especialidad->id ? 'selected' : '' }}>
                        {{ $especialidad->nombre }}
                    </option>
                @endforeach
            </x-ui.select>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input type="date" name="fecha" label="Fecha" :value="$cita->fecha" required />
                <x-ui.input type="time" name="hora" label="Hora" :value="$cita->hora" required />
            </div>

            <x-ui.textarea name="motivo" label="Motivo" rows="3" required>{{ $cita->motivo }}</x-ui.textarea>

            <x-ui.select name="estado" label="Estado" required>
                <option value="">Seleccione</option>
                <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </x-ui.select>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Actualizar</x-ui.button>
                <x-ui.button :href="route('citas.show', $cita->id)" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
