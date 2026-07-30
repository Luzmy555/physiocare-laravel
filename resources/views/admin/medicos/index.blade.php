<x-layouts.internal :title="'Gestión de Fisioterapeutas - FisioCare Ayla'">
    <x-ui.page-header title="Gestión de Fisioterapeutas" :subtitle="'Total: ' . $medicos->total() . ' fisioterapeutas'">
        <x-slot:actions>
            <x-ui.button :href="route('admin.medicos.create')" variant="success"><i class="fa-solid fa-plus"></i> Nuevo Fisioterapeuta</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    @if ($medicos->count() > 0)
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3">Especialidad</th>
                    <th class="px-6 py-3">Colegiado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($medicos as $medico)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold text-ink">{{ $medico->nombre }} {{ $medico->apellido }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $medico->correo }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $medico->telefono }}</td>
                        <td class="px-6 py-3"><x-ui.badge color="green">{{ $medico->especialidad->nombre }}</x-ui.badge></td>
                        <td class="px-6 py-3 text-slate-600">{{ $medico->numero_colegiado }}</td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.medicos.edit', $medico->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-blue-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-600">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <form action="{{ route('admin.medicos.destroy', $medico->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
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

        @if ($medicos instanceof \Illuminate\Pagination\Paginator)
            <div class="mt-6">{{ $medicos->links() }}</div>
        @endif
    @else
        <x-ui.card>
            <x-ui.empty-state icon="fa-user-doctor" title="No hay médicos registrados" />
        </x-ui.card>
    @endif

    <div class="mt-6 text-center">
        <x-ui.button :href="route('dashboard')" variant="secondary"><i class="fa-solid fa-arrow-left"></i> Volver</x-ui.button>
    </div>
</x-layouts.internal>
