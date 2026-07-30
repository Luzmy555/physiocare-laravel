<x-layouts.internal :title="'Crear Usuario - FisioCare Ayla'">
    <x-ui.page-header title="Crear Usuario" subtitle="Alta de un nuevo usuario del sistema" />

    <x-ui.card class="mx-auto max-w-2xl">
        @if(session('success'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-5">
            @csrf

            <x-ui.input type="text" name="name" label="Nombre" :value="old('name')" required />
            <x-ui.input type="email" name="email" label="Email" :value="old('email')" required />
            <x-ui.input type="password" name="password" label="Contraseña" required />
            <x-ui.input type="password" name="password_confirmation" label="Confirmar Contraseña" required />

            <x-ui.select name="rol_id" label="Rol" required>
                <option value="">-- Seleccionar --</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ ucfirst($rol->nombre_rol) }}</option>
                @endforeach
            </x-ui.select>

            <div class="flex gap-3 pt-2">
                <x-ui.button type="submit">Crear Usuario</x-ui.button>
                <x-ui.button :href="route('admin.usuarios.index')" variant="secondary">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
