<x-layouts.internal :title="'Especialidad - FisioCare Ayla'">
    <x-ui.page-header title="Detalles de la Especialidad">
        <x-slot:actions>
            <x-ui.button :href="route('especialidades.edit', $especialidad->id)" variant="outline"><i class="fa-solid fa-pen"></i> Editar</x-ui.button>
            <x-ui.button :href="route('especialidades.index')" variant="secondary">Volver</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <x-ui.card class="mb-6">
        <p class="mb-2 text-sm"><strong class="text-ink">Nombre:</strong> <span class="text-slate-600">{{ $especialidad->nombre }}</span></p>
        <p class="mb-1 text-sm"><strong class="text-ink">Descripción:</strong></p>
        <p class="mb-2 text-sm text-slate-600">{{ $especialidad->descripcion }}</p>
        <p class="text-sm"><strong class="text-ink">Registrado:</strong> <span class="text-slate-600">{{ $especialidad->created_at->format('d/m/Y H:i') }}</span></p>
    </x-ui.card>

    <x-ui.card padding="p-0">
        <div class="border-b border-slate-100 px-6 py-4">
            <p class="font-poppins text-base font-bold text-ink">Fisioterapeutas ({{ $especialidad->fisioterapeutas->count() }})</p>
        </div>
        @if ($especialidad->fisioterapeutas->count() > 0)
            <x-ui.table>
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Número Colegiatura</th>
                        <th class="px-6 py-3">Teléfono</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($especialidad->fisioterapeutas as $fisiote)
                        <tr>
                            <td class="px-6 py-3">{{ $fisiote->nombre ?? 'N/A' }} {{ $fisiote->apellido ?? '' }}</td>
                            <td class="px-6 py-3">{{ $fisiote->correo ?? 'N/A' }}</td>
                            <td class="px-6 py-3">{{ $fisiote->numero_colegiado }}</td>
                            <td class="px-6 py-3">{{ $fisiote->telefono ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-ui.table>
        @else
            <p class="px-6 py-6 text-sm text-slate-400">No hay fisioterapeutas en esta especialidad</p>
        @endif
    </x-ui.card>
</x-layouts.internal>
