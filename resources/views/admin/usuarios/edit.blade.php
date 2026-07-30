<x-layouts.internal :title="'Editar Usuario - FisioCare Ayla'">
    <x-ui.page-header title="Editar Usuario" :subtitle="$usuario->name" />

    <x-ui.card class="mx-auto max-w-2xl">
        @if(session('success'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <x-ui.input type="text" name="name" label="Nombre" :value="old('name', $usuario->name)" required />
            <x-ui.input type="email" name="email" label="Email" :value="old('email', $usuario->email)" required />
            <x-ui.input type="password" name="password" label="Contraseña (dejar en blanco para no cambiar)" />
            <x-ui.input type="password" name="password_confirmation" label="Confirmar Contraseña" />

            <x-ui.select name="rol_id" label="Rol" required>
                <option value="">-- Seleccionar --</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}" {{ (old('rol_id', $usuario->rol_id ?? '') == $rol->id) ? 'selected' : '' }}>{{ ucfirst($rol->nombre_rol) }}</option>
                @endforeach
            </x-ui.select>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit">Guardar Cambios</x-ui.button>
                <x-ui.button :href="route('admin.usuarios.index')" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
