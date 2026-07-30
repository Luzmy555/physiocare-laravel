<x-layouts.internal :title="'Citas - FisioCare Ayla'">
    <x-ui.page-header title="Citas" subtitle="Listado de citas internas">
        <x-slot:actions>
            <x-ui.button :href="route('citas.create')"><i class="fa-solid fa-plus"></i> Nueva Cita</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    @if ($message = Session::get('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ $message }}
        </div>
    @endif

    @if ($citas->count() > 0)
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Paciente</th>
                    <th class="px-6 py-3">Fisioterapeuta</th>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Hora</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($citas as $cita)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold text-ink">{{ $cita->paciente->nombre ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->fisioterapeuta->nombre ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->fecha }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->hora }}</td>
                        <td class="px-6 py-3">
                            @if ($cita->estado == 'pendiente')
                                <x-ui.badge color="amber">Pendiente</x-ui.badge>
                            @elseif ($cita->estado == 'confirmada')
                                <x-ui.badge color="green">Confirmada</x-ui.badge>
                            @else
                                <x-ui.badge color="red">Cancelada</x-ui.badge>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('citas.show', $cita->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-600">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('citas.edit', $cita->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-600">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta cita?');">
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
            <x-ui.empty-state icon="fa-calendar-days" title="No hay citas registradas" />
        </x-ui.card>
    @endif

    <div class="mt-6 flex justify-center">
        {{ $citas->links() }}
    </div>
</x-layouts.internal>
