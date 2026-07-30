<x-layouts.internal :title="'Mis Pacientes - FisioCare Ayla'">
    <x-ui.page-header title="Mis Pacientes" subtitle="Listado de pacientes que has atendido" />

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border-2 border-primary/30 bg-gradient-to-br from-primary/10 to-accent/10 p-6 text-center">
            <p class="text-3xl font-bold text-primary">{{ $estadisticas['total_pacientes'] ?? 0 }}</p>
            <p class="mt-1 text-xs font-semibold uppercase text-slate-500">Pacientes Totales</p>
        </div>
        <div class="rounded-2xl border-2 border-primary/30 bg-gradient-to-br from-primary/10 to-accent/10 p-6 text-center">
            <p class="text-3xl font-bold text-primary">{{ $estadisticas['citas_completadas'] ?? 0 }}</p>
            <p class="mt-1 text-xs font-semibold uppercase text-slate-500">Citas Completadas</p>
        </div>
        <div class="rounded-2xl border-2 border-primary/30 bg-gradient-to-br from-primary/10 to-accent/10 p-6 text-center">
            <p class="text-3xl font-bold text-primary">{{ $estadisticas['citas_proximas'] ?? 0 }}</p>
            <p class="mt-1 text-xs font-semibold uppercase text-slate-500">Citas Próximas</p>
        </div>
    </div>

    <x-ui.card class="mb-6">
        <input type="text" id="searchPaciente" placeholder="Buscar por nombre, email o teléfono..." class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/10">
    </x-ui.card>

    @if ($pacientes->count() > 0)
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($pacientes as $paciente)
                <div class="paciente-card rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-accent text-2xl font-bold text-white">
                        {{ strtoupper(substr($paciente['nombre'], 0, 1)) }}
                    </div>

                    <p class="mb-2 text-base font-bold text-ink">{{ $paciente['nombre'] }} {{ $paciente['apellido'] }}</p>

                    <p class="mb-1 text-sm text-slate-500"><i class="fa-solid fa-envelope w-4"></i> {{ $paciente['correo'] }}</p>
                    <p class="mb-3 text-sm text-slate-500"><i class="fa-solid fa-phone w-4"></i> {{ $paciente['telefono'] }}</p>

                    <div class="my-4 flex gap-2 border-y border-slate-100 py-4">
                        <div class="flex-1 text-center">
                            <p class="text-lg font-bold text-primary">{{ $paciente['citas_totales'] }}</p>
                            <p class="text-[11px] font-semibold uppercase text-slate-400">Citas</p>
                        </div>
                        <div class="flex-1 text-center">
                            <p class="text-lg font-bold text-primary">{{ $paciente['citas_completadas'] }}</p>
                            <p class="text-[11px] font-semibold uppercase text-slate-400">Completadas</p>
                        </div>
                        <div class="flex-1 text-center">
                            <p class="text-lg font-bold text-primary">{{ $paciente['citas_proximas'] }}</p>
                            <p class="text-[11px] font-semibold uppercase text-slate-400">Próximas</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        @if($paciente['historial_id'])
                            <a href="{{ route('historiales.show', $paciente['historial_id']) }}" class="flex-1 rounded-lg bg-primary py-2 text-center text-xs font-semibold text-white hover:bg-primary-dark">
                                <i class="fa-solid fa-clipboard-list"></i> Ver
                            </a>
                            <a href="{{ route('historiales.edit', $paciente['historial_id']) }}" class="flex-1 rounded-lg bg-amber-500 py-2 text-center text-xs font-semibold text-white hover:bg-amber-600">
                                <i class="fa-solid fa-pen"></i> Editar
                            </a>
                            <form action="{{ route('historiales.destroy', $paciente['historial_id']) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Seguro que desea eliminar el historial?')" class="w-full rounded-lg bg-red-500 py-2 text-xs font-semibold text-white hover:bg-red-600">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <span class="flex-1 rounded-lg bg-slate-100 py-2 text-center text-xs font-semibold text-slate-400">Sin historial</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-ui.card>
            <x-ui.empty-state icon="fa-users" title="No tienes pacientes registrados" text="Los pacientes aparecerán aquí cuando agenden citas contigo" />
        </x-ui.card>
    @endif

    <script>
        document.getElementById('searchPaciente').addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.paciente-card').forEach(card => {
                card.style.display = card.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</x-layouts.internal>
