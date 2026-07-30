<x-layouts.internal :title="'Rol - FisioCare Ayla'">
    <x-ui.page-header title="Detalles del Rol">
        <x-slot:actions>
            <x-ui.button :href="route('roles.edit', $rol->id)" variant="outline"><i class="fa-solid fa-pen"></i> Editar</x-ui.button>
            <x-ui.button :href="route('roles.index')" variant="secondary">Volver</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <x-ui.card class="mb-6">
        <p class="mb-2 text-sm"><strong class="text-ink">Nombre:</strong> <span class="capitalize text-slate-600">{{ $rol->nombre_rol }}</span></p>
        <p class="mb-1 text-sm"><strong class="text-ink">Descripción:</strong></p>
        <p class="mb-2 text-sm text-slate-600">{{ $rol->descripcion }}</p>
        <p class="text-sm"><strong class="text-ink">Registrado:</strong> <span class="text-slate-600">{{ $rol->created_at->format('d/m/Y H:i') }}</span></p>
    </x-ui.card>

    <x-ui.card padding="p-0">
        <div class="border-b border-slate-100 px-6 py-4">
            <p class="font-poppins text-base font-bold text-ink">Usuarios Asignados ({{ $rol->usuarios->count() }})</p>
        </div>
        @if ($rol->usuarios->count() > 0)
            <x-ui.table>
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Registrado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($rol->usuarios as $usuario)
                        <tr>
                            <td class="px-6 py-3">{{ $usuario->name }}</td>
                            <td class="px-6 py-3">{{ $usuario->email }}</td>
                            <td class="px-6 py-3">{{ $usuario->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-ui.table>
        @else
            <p class="px-6 py-6 text-sm text-slate-400">No hay usuarios asignados a este rol</p>
        @endif
    </x-ui.card>
</x-layouts.internal>
