<x-layouts.internal :title="'Editar Especialidad - FisioCare Ayla'">
    <x-ui.page-header title="Editar Especialidad" :subtitle="$especialidad->nombre" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('especialidades.update', $especialidad->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <x-ui.input type="text" name="nombre" label="Nombre" :value="old('nombre', $especialidad->nombre)" required />
            <x-ui.textarea name="descripcion" label="Descripción" rows="4" required>{{ old('descripcion', $especialidad->descripcion) }}</x-ui.textarea>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Actualizar</x-ui.button>
                <x-ui.button :href="route('especialidades.show', $especialidad->id)" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
