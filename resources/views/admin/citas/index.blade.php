<x-layouts.internal :title="'Gestionar Citas - FisioCare Ayla'">
    <x-ui.page-header title="Gestionar Citas" :subtitle="'Total de citas registradas: ' . $citas->total()" />

    <x-ui.card class="mb-6">
        <form action="{{ route('admin.citas.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="min-w-[200px] flex-1">
                <x-ui.select name="estado" label="Estado">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmada" {{ request('estado') === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="completada" {{ request('estado') === 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </x-ui.select>
            </div>
            <div class="min-w-[200px] flex-1">
                <x-ui.input type="date" name="fecha" label="Fecha" :value="request('fecha')" />
            </div>
            <x-ui.button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Filtrar</x-ui.button>
        </form>
    </x-ui.card>

    @if ($citas->count() > 0)
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Paciente</th>
                    <th class="px-6 py-3">Médico</th>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Hora</th>
                    <th class="px-6 py-3">Especialidad</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($citas as $cita)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3">
                            <p class="font-semibold text-ink">{{ $cita->nombres }} {{ $cita->apellidos }}</p>
                            <p class="text-xs text-slate-400">{{ $cita->correo }}</p>
                        </td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->fisioterapeuta->nombre }} {{ $cita->fisioterapeuta->apellido }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->fecha_cita->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->hora_cita }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->especialidad->nombre }}</td>
                        <td class="px-6 py-3">
                            <x-ui.badge :color="match($cita->estado) { 'confirmada' => 'green', 'cancelada' => 'red', default => 'amber' }">
                                {{ ucfirst($cita->estado) }}
                            </x-ui.badge>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex flex-wrap gap-2">
                                @if ($cita->estado !== 'confirmada')
                                    <form action="{{ route('admin.citas.confirmar', $cita->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-600">
                                            <i class="fa-solid fa-check"></i> Confirmar
                                        </button>
                                    </form>
                                @endif
                                @if ($cita->estado !== 'cancelada')
                                    <form action="{{ route('admin.citas.cancelar', $cita->id) }}" method="POST" onsubmit="return confirm('¿Cancelar esta cita?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600">
                                            <i class="fa-solid fa-xmark"></i> Cancelar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table>

        <div class="mt-6">{{ $citas->links() }}</div>
    @else
        <x-ui.card>
            <x-ui.empty-state icon="fa-inbox" title="No hay citas" />
        </x-ui.card>
    @endif

    <div class="mt-6 text-center">
        <x-ui.button :href="route('dashboard')" variant="secondary"><i class="fa-solid fa-arrow-left"></i> Volver al panel</x-ui.button>
    </div>
</x-layouts.internal>
