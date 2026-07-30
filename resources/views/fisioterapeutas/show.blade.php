<x-layouts.internal :title="'Fisioterapeuta - FisioCare Ayla'">
    <x-ui.page-header title="Detalles del Fisioterapeuta">
        <x-slot:actions>
            <x-ui.button :href="route('fisioterapeutas.edit', $fisioterapeuta->id)" variant="outline"><i class="fa-solid fa-pen"></i> Editar</x-ui.button>
            <x-ui.button :href="route('fisioterapeutas.index')" variant="secondary">Volver</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <x-ui.card class="mb-6">
        <div class="grid grid-cols-1 gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
            <p><strong class="text-ink">Nombre:</strong> <span class="text-slate-600">{{ $fisioterapeuta->nombre ?? 'N/A' }} {{ $fisioterapeuta->apellido ?? '' }}</span></p>
            <p><strong class="text-ink">Email:</strong> <span class="text-slate-600">{{ $fisioterapeuta->correo ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Especialidad:</strong> <span class="text-slate-600">{{ $fisioterapeuta->especialidad->nombre ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Número Colegiatura:</strong> <span class="text-slate-600">{{ $fisioterapeuta->numero_colegiado }}</span></p>
            <p><strong class="text-ink">Teléfono:</strong> <span class="text-slate-600">{{ $fisioterapeuta->telefono ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Registrado:</strong> <span class="text-slate-600">{{ $fisioterapeuta->created_at->format('d/m/Y H:i') }}</span></p>
        </div>
    </x-ui.card>

    <x-ui.card padding="p-0">
        <div class="border-b border-slate-100 px-6 py-4">
            <p class="font-poppins text-base font-bold text-ink">Citas ({{ $fisioterapeuta->citas->count() }})</p>
        </div>
        @if ($fisioterapeuta->citas->count() > 0)
            <x-ui.table>
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Hora</th>
                        <th class="px-6 py-3">Paciente</th>
                        <th class="px-6 py-3">Motivo</th>
                        <th class="px-6 py-3">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($fisioterapeuta->citas as $cita)
                        <tr>
                            <td class="px-6 py-3">{{ $cita->fecha_cita }}</td>
                            <td class="px-6 py-3">{{ $cita->hora_cita }}</td>
                            <td class="px-6 py-3">{{ $cita->paciente->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-3">{{ $cita->motivo }}</td>
                            <td class="px-6 py-3"><x-ui.badge>{{ $cita->estado }}</x-ui.badge></td>
                        </tr>
                    @endforeach
                </tbody>
            </x-ui.table>
        @else
            <p class="px-6 py-6 text-sm text-slate-400">No hay citas registradas</p>
        @endif
    </x-ui.card>
</x-layouts.internal>
