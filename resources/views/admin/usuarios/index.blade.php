<x-layouts.internal :title="'Gestionar Usuarios - FisioCare Ayla'">
    <x-ui.page-header title="Gestionar Usuarios" :subtitle="'Total: ' . $usuarios->count() . ' usuarios'">
        <x-slot:actions>
            <x-ui.button :href="route('admin.usuarios.create')"><i class="fa-solid fa-plus"></i> Nuevo Usuario</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    @if ($usuarios->count() > 0)
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Rol</th>
                    <th class="px-6 py-3">Registrado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($usuarios as $usuario)
                    @php
                        $rolColor = match($usuario->rol->nombre_rol ?? 'paciente') {
                            'admin' => 'red',
                            'medico', 'fisioterapeuta' => 'green',
                            default => 'blue',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold text-ink">{{ $usuario->name }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $usuario->email }}</td>
                        <td class="px-6 py-3">
                            <x-ui.badge :color="$rolColor">{{ ucfirst($usuario->rol->nombre_rol ?? 'Paciente') }}</x-ui.badge>
                        </td>
                        <td class="px-6 py-3 text-slate-500">{{ $usuario->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-blue-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-600">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table>
    @else
        <x-ui.card>
            <x-ui.empty-state icon="fa-users" title="No hay usuarios" />
        </x-ui.card>
    @endif

    <div class="mt-6 text-center">
        <x-ui.button :href="route('dashboard')" variant="secondary"><i class="fa-solid fa-arrow-left"></i> Volver</x-ui.button>
    </div>
</x-layouts.internal>
