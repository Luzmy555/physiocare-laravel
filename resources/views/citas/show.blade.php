<x-layouts.internal :title="'Cita - FisioCare Ayla'">
    <x-ui.page-header title="Detalles de la Cita">
        <x-slot:actions>
            <x-ui.button :href="route('citas.edit', $cita->id)" variant="outline"><i class="fa-solid fa-pen"></i> Editar</x-ui.button>
            <x-ui.button :href="route('citas.index')" variant="secondary">Volver</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <x-ui.card>
        <div class="mb-4 grid grid-cols-1 gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
            <p><strong class="text-ink">Paciente:</strong> <span class="text-slate-600">{{ $cita->paciente->nombre ?? 'N/A' }} {{ $cita->paciente->apellido ?? '' }}</span></p>
            <p><strong class="text-ink">Fisioterapeuta:</strong> <span class="text-slate-600">{{ $cita->fisioterapeuta->nombre ?? 'N/A' }} {{ $cita->fisioterapeuta->apellido ?? '' }}</span></p>
            <p><strong class="text-ink">Email Paciente:</strong> <span class="text-slate-600">{{ $cita->paciente->correo ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Especialidad:</strong> <span class="text-slate-600">{{ $cita->especialidad->nombre ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Teléfono:</strong> <span class="text-slate-600">{{ $cita->paciente->telefono ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Número Colegiatura:</strong> <span class="text-slate-600">{{ $cita->fisioterapeuta->numero_colegiado }}</span></p>
        </div>

        <div class="mb-4 grid grid-cols-1 gap-x-8 gap-y-2 border-t border-slate-100 pt-4 text-sm sm:grid-cols-2">
            <p><strong class="text-ink">Fecha:</strong> <span class="text-slate-600">{{ $cita->fecha }}</span></p>
            <p><strong class="text-ink">Hora:</strong> <span class="text-slate-600">{{ $cita->hora }}</span></p>
            <p>
                <strong class="text-ink">Estado:</strong>
                @if ($cita->estado == 'pendiente')
                    <x-ui.badge color="amber">Pendiente</x-ui.badge>
                @elseif ($cita->estado == 'confirmada')
                    <x-ui.badge color="green">Confirmada</x-ui.badge>
                @else
                    <x-ui.badge color="red">Cancelada</x-ui.badge>
                @endif
            </p>
        </div>

        <div class="border-t border-slate-100 pt-4 text-sm">
            <p class="mb-1 font-semibold text-ink">Motivo</p>
            <p class="text-slate-600">{{ $cita->motivo }}</p>
            <p class="mt-3 text-xs text-slate-400">Registrada: {{ $cita->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </x-ui.card>
</x-layouts.internal>
