<x-layouts.internal :title="'Nuevo Historial - FisioCare Ayla'">
    <x-ui.page-header title="Crear Nuevo Historial Clínico" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('historiales.store') }}" method="POST" class="space-y-5">
            @csrf

            <x-ui.select name="paciente_id" label="Paciente" required>
                <option value="">Seleccione un paciente</option>
                @foreach ($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                        {{ $paciente->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.select name="fisioterapeuta_id" label="Fisioterapeuta" required>
                <option value="">Seleccione un fisioterapeuta</option>
                @foreach ($fisioterapeutas as $fisioterapeuta)
                    <option value="{{ $fisioterapeuta->id }}" {{ old('fisioterapeuta_id') == $fisioterapeuta->id ? 'selected' : '' }}>
                        {{ $fisioterapeuta->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.textarea name="observaciones" label="Descripción" rows="3" required>{{ old('observaciones') }}</x-ui.textarea>
            <x-ui.textarea name="diagnostico" label="Diagnóstico" rows="3" required>{{ old('diagnostico') }}</x-ui.textarea>
            <x-ui.textarea name="tratamiento" label="Tratamiento" rows="3" required>{{ old('tratamiento') }}</x-ui.textarea>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Guardar</x-ui.button>
                <x-ui.button :href="route('historiales.index')" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
