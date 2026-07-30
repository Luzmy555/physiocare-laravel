<x-layouts.internal :title="'Editar Rol - FisioCare Ayla'">
    <x-ui.page-header title="Editar Rol" :subtitle="$rol->nombre_rol" />

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('roles.update', $rol->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <x-ui.input type="text" name="nombre_rol" label="Nombre del Rol" :value="old('nombre_rol', $rol->nombre_rol)" required />
            <x-ui.textarea name="descripcion" label="Descripción" rows="4" required>{{ old('descripcion', $rol->descripcion) }}</x-ui.textarea>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit" variant="success">Actualizar</x-ui.button>
                <x-ui.button :href="route('roles.show', $rol->id)" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
