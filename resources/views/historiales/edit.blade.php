<x-layouts.internal :title="'Editar Historial - FisioCare Ayla'">
    <x-ui.page-header title="Editar Historial Clínico" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('historiales.update', $historial->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <x-ui.select name="paciente_id" label="Paciente" required>
                <option value="">Seleccione un paciente</option>
                @foreach ($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ $historial->paciente_id == $paciente->id ? 'selected' : '' }}>
                        {{ $paciente->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.select name="fisioterapeuta_id" label="Fisioterapeuta" required>
                <option value="">Seleccione un fisioterapeuta</option>
                @foreach ($fisioterapeutas as $fisioterapeuta)
                    <option value="{{ $fisioterapeuta->id }}" {{ $historial->fisioterapeuta_id == $fisioterapeuta->id ? 'selected' : '' }}>
                        {{ $fisioterapeuta->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </x-ui.select>

            <x-ui.textarea name="observaciones" label="Descripción" rows="3" required>{{ $historial->observaciones }}</x-ui.textarea>
            <x-ui.textarea name="diagnostico" label="Diagnóstico" rows="3" required>{{ $historial->diagnostico }}</x-ui.textarea>
            <x-ui.textarea name="tratamiento" label="Tratamiento" rows="3" required>{{ $historial->tratamiento }}</x-ui.textarea>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Actualizar</x-ui.button>
                <x-ui.button :href="route('historiales.show', $historial->id)" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
