<x-layouts.internal :title="'Fisioterapeutas - FisioCare Ayla'">
    <x-ui.page-header title="Fisioterapeutas" subtitle="Plantilla de profesionales">
        <x-slot:actions>
            <x-ui.button :href="route('fisioterapeutas.create')"><i class="fa-solid fa-plus"></i> Nuevo Fisioterapeuta</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    @if ($message = Session::get('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ $message }}
        </div>
    @endif

    @if ($fisioterapeutas->count() > 0)
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Especialidad</th>
                    <th class="px-6 py-3">Número Colegiatura</th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($fisioterapeutas as $fisioterapeuta)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold text-ink">{{ $fisioterapeuta->nombre ?? 'N/A' }} {{ $fisioterapeuta->apellido ?? '' }}</td>
                        <td class="px-6 py-3"><x-ui.badge color="green">{{ $fisioterapeuta->especialidad->nombre ?? 'N/A' }}</x-ui.badge></td>
                        <td class="px-6 py-3 text-slate-600">{{ $fisioterapeuta->numero_colegiatura }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $fisioterapeuta->telefono ?? 'N/A' }}</td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('fisioterapeutas.show', $fisioterapeuta->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-600">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('fisioterapeutas.edit', $fisioterapeuta->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-600">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('fisioterapeutas.destroy', $fisioterapeuta->id) }}" method="POST" onsubmit="return confirm('¿Está seguro?')">
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
            <x-ui.empty-state icon="fa-user-doctor" title="No hay fisioterapeutas registrados" />
        </x-ui.card>
    @endif

    <div class="mt-6 flex justify-center">
        {{ $fisioterapeutas->links() }}
    </div>
</x-layouts.internal>
