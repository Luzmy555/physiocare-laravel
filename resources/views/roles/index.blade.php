<x-layouts.internal :title="'Roles - FisioCare Ayla'">
    <x-ui.page-header title="Roles" subtitle="Roles del sistema y usuarios asignados">
        <x-slot:actions>
            <x-ui.button :href="route('roles.create')"><i class="fa-solid fa-plus"></i> Nuevo Rol</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    @if ($message = Session::get('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ $message }}
        </div>
    @endif

    @if ($roles->count() > 0)
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Descripción</th>
                    <th class="px-6 py-3">Usuarios</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($roles as $rol)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold capitalize text-ink">{{ $rol->nombre_rol }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ Str::limit($rol->descripcion, 50) }}</td>
                        <td class="px-6 py-3"><x-ui.badge color="blue">{{ $rol->usuarios_count }}</x-ui.badge></td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('roles.show', $rol->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-600">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('roles.edit', $rol->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-600">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" onsubmit="return confirm('¿Está seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600">
                                        <i class="fa-solid fa-trash"></i>
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
            <x-ui.empty-state icon="fa-user-shield" title="No hay roles registrados" />
        </x-ui.card>
    @endif

    <div class="mt-6 flex justify-center">
        {{ $roles->links() }}
    </div>
</x-layouts.internal>
