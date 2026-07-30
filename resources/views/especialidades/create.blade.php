<x-layouts.internal :title="'Nueva Especialidad - FisioCare Ayla'">
    <x-ui.page-header title="Crear Nueva Especialidad" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('especialidades.store') }}" method="POST" class="space-y-5">
            @csrf

            <x-ui.input type="text" name="nombre" label="Nombre" :value="old('nombre')" required />
            <x-ui.textarea name="descripcion" label="Descripción" rows="4" required>{{ old('descripcion') }}</x-ui.textarea>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Guardar</x-ui.button>
                <x-ui.button :href="route('especialidades.index')" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
