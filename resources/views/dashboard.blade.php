<x-layouts.internal :title="'Dashboard - FisioCare Ayla'">

    @if ($rol === 'fisioterapeuta')
        <x-ui.page-header
            :title="'Bienvenido/a, Dr. ' . $fisioterapeuta->nombre . ' ' . $fisioterapeuta->apellido"
            :subtitle="'Especialidad: ' . ($fisioterapeuta->especialidad->nombre ?? 'Sin especialidad') . ' · Última sesión: ' . ($ultimaSesion ?? 'Sin registros')"
        />

        <div class="mb-8 rounded-2xl border border-primary/20 bg-primary/5 px-6 py-4 text-sm text-ink">
            Hoy tienes <b>{{ $totalCitasHoy }}</b> citas programadas.
            Tu próxima cita es a las <b>{{ $proximaCitaHora }}</b> con <b>{{ $proximaCitaPaciente }}</b>.
        </div>

        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-ui.card>
                <div class="flex items-start justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Citas pendientes</p>
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500 text-white"><i class="fa-solid fa-hourglass-half"></i></div>
                </div>
                <p class="mt-3 text-3xl font-bold text-ink">{{ $cantidadPendientes }}</p>
                <p class="mt-1 text-xs text-slate-400">Por atender</p>
            </x-ui.card>
            <x-ui.card>
                <div class="flex items-start justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pacientes atendidos este mes</p>
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-500 text-white"><i class="fa-solid fa-users"></i></div>
                </div>
                <p class="mt-3 text-3xl font-bold text-ink">{{ $totalPacientesMes }}</p>
                <p class="mt-1 text-xs text-slate-400">En el mes actual</p>
            </x-ui.card>
        </div>

        <x-ui.card class="mb-8" padding="p-0">
            <div class="border-b border-slate-100 px-6 py-4">
                <p class="font-poppins text-base font-bold text-ink"><i class="fa-solid fa-calendar-days mr-2 text-primary"></i>Agenda del Día</p>
            </div>
            <x-ui.table>
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Hora</th>
                        <th class="px-6 py-3">Paciente</th>
                        <th class="px-6 py-3">Motivo</th>
                        <th class="px-6 py-3">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($citasHoy as $cita)
                        <tr>
                            <td class="px-6 py-3">{{ $cita->hora_cita }}</td>
                            <td class="px-6 py-3">{{ $cita->nombres }} {{ $cita->apellidos }}</td>
                            <td class="px-6 py-3">{{ $cita->motivo }}</td>
                            <td class="px-6 py-3">{{ ucfirst($cita->estado) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-ui.table>
        </x-ui.card>

        <x-ui.card class="mb-8">
            <p class="mb-4 font-poppins text-base font-bold text-ink"><i class="fa-solid fa-clipboard-list mr-2 text-primary"></i>Historiales Clínicos Recientes</p>
            <ul class="space-y-2 text-sm">
                @foreach ($historialesRecientes as $historial)
                    <li>
                        <b>{{ $historial->paciente->nombre ?? 'N/A' }} {{ $historial->paciente->apellido ?? '' }}</b> — {{ $historial->observaciones }}
                        <span class="text-slate-400">({{ $historial->created_at->format('d/m/Y') }})</span>
                    </li>
                @endforeach
            </ul>
        </x-ui.card>

        <x-ui.card>
            <p class="mb-4 font-poppins text-base font-bold text-ink"><i class="fa-solid fa-bell mr-2 text-primary"></i>Notificaciones Recientes</p>
            <ul class="space-y-2 text-sm text-slate-600">
                @foreach ($notificaciones as $noti)
                    <li>{{ $noti->mensaje }}</li>
                @endforeach
            </ul>
        </x-ui.card>
    @else
        <x-ui.page-header
            :title="$rol === 'paciente' ? 'Bienvenido, ' . Auth::user()->name : ($rol === 'admin' ? 'Panel Administrativo' : 'Dashboard')"
            :subtitle="$rol === 'paciente' ? 'Gestiona tus citas y tu perfil' : ($rol === 'admin' ? 'Control total de la clínica' : null)"
        >
            @if ($rol === 'paciente')
                <x-slot:actions>
                    <x-ui.button :href="route('citas.publicas.create')" variant="outline"><i class="fa-solid fa-plus"></i> Agendar Nueva Cita</x-ui.button>
                </x-slot:actions>
            @elseif ($rol === 'admin')
                <x-slot:actions>
                    <x-ui.button :href="route('admin.usuarios.index')" variant="outline"><i class="fa-solid fa-gear"></i> Panel de Gestión</x-ui.button>
                </x-slot:actions>
            @endif
        </x-ui.page-header>

        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @if ($rol === 'paciente')
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Citas Totales</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500 text-white"><i class="fa-solid fa-chart-line"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_totales'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Todas tus citas agendadas</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Próximas Citas</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500 text-white"><i class="fa-solid fa-calendar-days"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_proximas'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Citas pendientes</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Completadas</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-500 text-white"><i class="fa-solid fa-check"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_completadas'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Citas finalizadas</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Canceladas</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-500 text-white"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_canceladas'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Citas canceladas</p>
                </x-ui.card>
            @elseif ($rol === 'medico')
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Citas Totales</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500 text-white"><i class="fa-solid fa-chart-line"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_totales'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">En tu historial</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Citas Hoy</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500 text-white"><i class="fa-solid fa-fire"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_hoy'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Por atender hoy</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Próximas</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500 text-white"><i class="fa-solid fa-calendar-days"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_proximas'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Próximos días</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pacientes Únicos</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-500 text-white"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['pacientes_unicos'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Atendidos</p>
                </x-ui.card>
            @elseif ($rol === 'admin')
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Citas Totales</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500 text-white"><i class="fa-solid fa-chart-line"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_totales'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">En el sistema</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Citas Hoy</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500 text-white"><i class="fa-solid fa-fire"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_hoy'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Programadas para hoy</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pendientes</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500 text-white"><i class="fa-solid fa-hourglass-half"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_pendientes'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Por confirmar</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Confirmadas</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-500 text-white"><i class="fa-solid fa-check"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['citas_confirmadas'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Confirmadas</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pacientes</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500 text-white"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['pacientes_unicos'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">Únicos</p>
                </x-ui.card>
                <x-ui.card>
                    <div class="flex items-start justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Fisioterapeutas</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-500 text-white"><i class="fa-solid fa-user-doctor"></i></div>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-ink">{{ $stats['fisioterapeutas_totales'] ?? 0 }}</p>
                    <p class="mt-1 text-xs text-slate-400">En plantilla</p>
                </x-ui.card>
            @endif
        </div>

        @if ($rol === 'paciente')
            <x-ui.card class="mb-8" padding="p-0">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                    <div>
                        <p class="font-poppins text-base font-bold text-ink"><i class="fa-solid fa-calendar-days mr-2 text-primary"></i>Próximas Citas</p>
                        <p class="mt-0.5 text-xs text-slate-400">Tus citas programadas para los próximos días</p>
                    </div>
                    <x-ui.button href="/agendar-cita" class="!px-3 !py-1.5 !text-xs"><i class="fa-solid fa-plus"></i> Nueva Cita</x-ui.button>
                </div>

                @php
                    $citasProximas = \App\Models\CitaPublica::where('correo', Auth::user()->email)
                        ->where('fecha_cita', '>=', today())
                        ->where('estado', '!=', 'cancelada')
                        ->orderBy('fecha_cita')
                        ->limit(5)
                        ->get();
                @endphp

                @if ($citasProximas->count() > 0)
                    <div class="divide-y divide-slate-100 px-6">
                        @foreach ($citasProximas as $cita)
                            <div class="flex gap-4 py-4">
                                <div class="w-16 shrink-0 text-center">
                                    <p class="text-xl font-bold text-primary">{{ $cita->fecha_cita->format('d') }}</p>
                                    <p class="text-xs text-slate-400">{{ strtoupper($cita->fecha_cita->format('M')) }}</p>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-ink">{{ $cita->fisioterapeuta->nombre }} {{ $cita->fisioterapeuta->apellido }}</p>
                                    <p class="text-xs text-slate-500"><strong>{{ $cita->especialidad->nombre }}</strong> • {{ $cita->hora_cita }}</p>
                                    <p class="text-xs text-slate-500">{{ $cita->motivo }}</p>
                                    <x-ui.badge :color="$cita->estado === 'confirmada' ? 'green' : ($cita->estado === 'cancelada' ? 'red' : 'amber')" class="mt-2">{{ ucfirst($cita->estado) }}</x-ui.badge>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-ui.empty-state icon="fa-inbox" title="No tienes citas programadas" text="¡Agenda tu primera cita ahora!">
                        <x-ui.button :href="route('citas.publicas.create')" class="!px-3 !py-1.5 !text-xs">Agendar Cita</x-ui.button>
                    </x-ui.empty-state>
                @endif
            </x-ui.card>

        @elseif ($rol === 'medico')
            <x-ui.card class="mb-8" padding="p-0">
                <div class="border-b border-slate-100 px-6 py-4">
                    <p class="font-poppins text-base font-bold text-ink"><i class="fa-solid fa-fire mr-2 text-primary"></i>Citas de Hoy</p>
                    <p class="mt-0.5 text-xs text-slate-400">Pacientes programados para hoy</p>
                </div>

                @if (isset($citasHoy) && $citasHoy->count() > 0)
                    <div class="divide-y divide-slate-100 px-6">
                        @foreach ($citasHoy as $cita)
                            <div class="flex gap-4 py-4">
                                <div class="w-16 shrink-0 text-center">
                                    <p class="text-lg font-bold text-amber-500">{{ $cita->hora_cita }}</p>
                                    <p class="text-xs text-slate-400">Hora</p>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-ink">{{ $cita->nombres }} {{ $cita->apellidos }}</p>
                                    <p class="text-xs text-slate-500"><i class="fa-solid fa-phone"></i> {{ $cita->telefono }} • <i class="fa-solid fa-envelope"></i> {{ $cita->correo }}</p>
                                    <p class="text-xs text-slate-500"><strong>{{ $cita->especialidad->nombre }}</strong> - {{ $cita->motivo }}</p>
                                    <x-ui.badge :color="$cita->estado === 'confirmada' ? 'green' : ($cita->estado === 'cancelada' ? 'red' : 'amber')" class="mt-2">{{ ucfirst($cita->estado) }}</x-ui.badge>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-ui.empty-state icon="fa-mug-hot" title="Sin citas hoy" text="¡Disfruta tu descanso!" />
                @endif
            </x-ui.card>

        @elseif ($rol === 'admin')
            <x-ui.card class="mb-8" padding="p-0">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                    <div>
                        <p class="font-poppins text-base font-bold text-ink"><i class="fa-solid fa-clipboard-list mr-2 text-primary"></i>Últimas Citas Agendadas</p>
                        <p class="mt-0.5 text-xs text-slate-400">Citas recientes en el sistema</p>
                    </div>
                    <x-ui.button :href="route('admin.citas.index')" class="!px-3 !py-1.5 !text-xs"><i class="fa-solid fa-eye"></i> Ver Todas</x-ui.button>
                </div>

                @if (isset($citasRecientes) && $citasRecientes->count() > 0)
                    <div class="divide-y divide-slate-100 px-6">
                        @foreach ($citasRecientes as $cita)
                            <div class="flex gap-4 py-4">
                                <div class="w-16 shrink-0 text-center">
                                    <p class="text-xl font-bold text-primary">{{ $cita->fecha_cita->format('d') }}</p>
                                    <p class="text-xs text-slate-400">{{ strtoupper($cita->fecha_cita->format('M')) }}</p>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-ink">{{ $cita->nombres }} {{ $cita->apellidos }}</p>
                                    <p class="text-xs text-slate-500"><i class="fa-solid fa-user-doctor"></i> {{ $cita->fisioterapeuta->nombre }} • <i class="fa-solid fa-hospital"></i> {{ $cita->especialidad->nombre }}</p>
                                    <p class="text-xs text-slate-500">{{ $cita->correo }}</p>
                                    <x-ui.badge :color="$cita->estado === 'confirmada' ? 'green' : ($cita->estado === 'cancelada' ? 'red' : 'amber')" class="mt-2">{{ ucfirst($cita->estado) }}</x-ui.badge>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-ui.empty-state icon="fa-inbox" title="No hay citas" />
                @endif
            </x-ui.card>

            <x-ui.card>
                <p class="mb-4 font-poppins text-base font-bold text-ink"><i class="fa-solid fa-gear mr-2 text-primary"></i>Gestión del Sistema</p>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('admin.usuarios.index') }}" class="flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-4 text-sm font-semibold text-white transition hover:bg-primary-dark">
                        <i class="fa-solid fa-users"></i> Gestionar Usuarios
                    </a>
                    <a href="{{ route('admin.medicos.index') }}" class="flex items-center justify-center gap-2 rounded-xl bg-accent-dark px-4 py-4 text-sm font-semibold text-white transition hover:bg-emerald-700">
                        <i class="fa-solid fa-user-doctor"></i> Gestionar Médicos
                    </a>
                    <a href="{{ route('admin.citas.index') }}" class="flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-4 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        <i class="fa-solid fa-calendar-check"></i> Ver Citas
                    </a>
                    <a href="#" class="flex items-center justify-center gap-2 rounded-xl bg-slate-600 px-4 py-4 text-sm font-semibold text-white transition hover:bg-slate-700">
                        <i class="fa-solid fa-gear"></i> Configuración
                    </a>
                </div>
            </x-ui.card>
        @endif

        @if ($rol === 'paciente')
            <x-ui.card class="mt-8">
                <p class="mb-4 font-poppins text-base font-bold text-ink"><i class="fa-solid fa-bolt mr-2 text-primary"></i>Acciones Rápidas</p>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <a href="{{ route('citas.publicas.create') }}" class="rounded-xl border-2 border-primary bg-primary/5 px-6 py-6 text-center text-sm font-semibold text-primary transition hover:bg-primary/10">
                        <i class="fa-solid fa-calendar-plus mb-1 block text-lg"></i> Agendar Nueva Cita
                    </a>
                    <a href="{{ route('profile.edit') }}" class="rounded-xl border-2 border-blue-400 bg-blue-50 px-6 py-6 text-center text-sm font-semibold text-blue-600 transition hover:bg-blue-100">
                        <i class="fa-solid fa-user mb-1 block text-lg"></i> Actualizar Perfil
                    </a>
                    <a href="/" class="rounded-xl border-2 border-emerald-400 bg-emerald-50 px-6 py-6 text-center text-sm font-semibold text-emerald-600 transition hover:bg-emerald-100">
                        <i class="fa-solid fa-house mb-1 block text-lg"></i> Ir al Inicio
                    </a>
                </div>
            </x-ui.card>
        @endif
    @endif
</x-layouts.internal>
