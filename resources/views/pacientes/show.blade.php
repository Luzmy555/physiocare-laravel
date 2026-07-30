<x-layouts.internal :title="'Paciente - FisioCare Ayla'">
    <x-ui.page-header title="Detalles del Paciente">
        <x-slot:actions>
            <x-ui.button :href="route('pacientes.edit', $paciente->id)" variant="outline"><i class="fa-solid fa-pen"></i> Editar</x-ui.button>
            <x-ui.button :href="route('pacientes.index')" variant="secondary">Volver</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <x-ui.card class="mb-6">
        <div class="grid grid-cols-1 gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
            <p><strong class="text-ink">Usuario:</strong> <span class="text-slate-600">{{ $paciente->nombre ?? 'N/A' }} {{ $paciente->apellido ?? '' }}</span></p>
            <p><strong class="text-ink">Email:</strong> <span class="text-slate-600">{{ $paciente->correo ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Fecha de Nacimiento:</strong> <span class="text-slate-600">{{ $paciente->fecha_nacimiento }}</span></p>
            <p><strong class="text-ink">Dirección:</strong> <span class="text-slate-600">{{ $paciente->direccion }}</span></p>
            <p><strong class="text-ink">Teléfono:</strong> <span class="text-slate-600">{{ $paciente->telefono }}</span></p>
            <p><strong class="text-ink">Sexo:</strong> <span class="text-slate-600">{{ $paciente->sexo == 'M' ? 'Masculino' : 'Femenino' }}</span></p>
            <p><strong class="text-ink">Registrado:</strong> <span class="text-slate-600">{{ $paciente->created_at->format('d/m/Y H:i') }}</span></p>
        </div>
    </x-ui.card>

    <x-ui.card class="mb-6" padding="p-0">
        <div class="border-b border-slate-100 px-6 py-4">
            <p class="font-poppins text-base font-bold text-ink">Citas ({{ $paciente->citas->count() }})</p>
        </div>
        @if ($paciente->citas->count() > 0)
            <x-ui.table>
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Hora</th>
                        <th class="px-6 py-3">Fisioterapeuta</th>
                        <th class="px-6 py-3">Motivo</th>
                        <th class="px-6 py-3">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($paciente->citas as $cita)
                        <tr>
                            <td class="px-6 py-3">{{ $cita->fecha_cita }}</td>
                            <td class="px-6 py-3">{{ $cita->hora_cita }}</td>
                            <td class="px-6 py-3">{{ $cita->fisioterapeuta->nombre ?? 'N/A' }}</td>
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

    <x-ui.card padding="p-0">
        <div class="border-b border-slate-100 px-6 py-4">
            <p class="font-poppins text-base font-bold text-ink">Historiales Clínicos ({{ $paciente->historiales->count() }})</p>
        </div>
        @if ($paciente->historiales->count() > 0)
            <x-ui.table>
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Fisioterapeuta</th>
                        <th class="px-6 py-3">Diagnóstico</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($paciente->historiales as $historial)
                        <tr>
                            <td class="px-6 py-3">{{ $historial->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">{{ $historial->fisioterapeuta->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-3">{{ $historial->diagnostico }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-ui.table>
        @else
            <p class="px-6 py-6 text-sm text-slate-400">No hay historiales clínicos registrados</p>
        @endif
    </x-ui.card>
</x-layouts.internal>
