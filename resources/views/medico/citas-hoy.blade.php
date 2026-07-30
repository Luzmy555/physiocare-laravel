<x-layouts.internal :title="'Citas de Hoy - FisioCare Ayla'">
    <x-ui.page-header title="Citas de Hoy" subtitle="Pacientes programados para hoy" />

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1fr_320px]">
        <x-ui.card>
            @if ($citasHoy->count() > 0)
                <div class="space-y-4">
                    @foreach ($citasHoy as $cita)
                        <div class="rounded-xl border-2 border-slate-200 p-6 transition hover:border-primary hover:shadow-md">
                            <div class="mb-3 flex items-start justify-between">
                                <div class="text-2xl font-bold text-primary">{{ $cita->hora_cita }}</div>
                                <x-ui.badge :color="match($cita->estado) { 'confirmada' => 'green', 'completada' => 'green', 'cancelada' => 'red', default => 'amber' }">
                                    {{ ucfirst($cita->estado) }}
                                </x-ui.badge>
                            </div>

                            <p class="mb-2 text-base font-bold text-ink">{{ $cita->nombres }} {{ $cita->apellidos }}</p>

                            <p class="mb-1 text-sm text-slate-500"><i class="fa-solid fa-phone w-4"></i> {{ $cita->telefono }}</p>
                            <p class="mb-1 text-sm text-slate-500"><i class="fa-solid fa-envelope w-4"></i> {{ $cita->correo }}</p>
                            <p class="mb-3 text-sm text-slate-500"><i class="fa-solid fa-hospital w-4"></i> <strong>{{ $cita->especialidad->nombre }}</strong></p>

                            <div class="mb-4 rounded-lg bg-slate-50 p-3 text-sm text-slate-600">
                                <strong class="text-ink">Motivo:</strong> {{ $cita->motivo }}
                            </div>

                            <div class="flex gap-2">
                                @if ($cita->estado !== 'confirmada')
                                    <form action="{{ route('medico.confirmar-cita', $cita->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-600">
                                            <i class="fa-solid fa-check"></i> Confirmar
                                        </button>
                                    </form>
                                @endif
                                <button type="button" onclick="openNoteModal({{ $cita->id }}, '{{ $cita->nombres }}')" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-600">
                                    <i class="fa-solid fa-note-sticky"></i> Nota
                                </button>
                                @if ($cita->receta)
                                    <a href="{{ route('medico.ver-receta', $cita->id) }}" target="_blank" class="inline-flex items-center gap-1 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700">
                                        <i class="fa-solid fa-file-prescription"></i> Ver Receta
                                    </a>
                                @else
                                    <button type="button" onclick="openRecetaModal({{ $cita->id }}, '{{ $cita->nombres }}')" class="inline-flex items-center gap-1 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700">
                                        <i class="fa-solid fa-file-prescription"></i> Receta
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state icon="fa-mug-hot" title="Sin citas hoy" text="¡Disfruta tu descanso!" />
            @endif
        </x-ui.card>

        <div class="space-y-4">
            <x-ui.card>
                <div class="mb-3 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 p-4 text-center">
                    <p class="text-3xl font-bold text-primary">{{ $citasHoy->count() }}</p>
                    <p class="text-xs font-semibold uppercase text-slate-500">Citas Hoy</p>
                </div>
                <div class="mb-3 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 p-4 text-center">
                    <p class="text-3xl font-bold text-primary">{{ $estadisticas['proximas'] ?? 0 }}</p>
                    <p class="text-xs font-semibold uppercase text-slate-500">Próximas</p>
                </div>
                <div class="mb-4 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 p-4 text-center">
                    <p class="text-3xl font-bold text-primary">{{ $estadisticas['pacientes_unicos'] ?? 0 }}</p>
                    <p class="text-xs font-semibold uppercase text-slate-500">Mis Pacientes</p>
                </div>

                <div class="space-y-2 border-t border-slate-100 pt-4">
                    <x-ui.button :href="route('medico.mis-citas')" class="w-full justify-center"><i class="fa-solid fa-calendar-days"></i> Todas Mis Citas</x-ui.button>
                    <x-ui.button :href="route('medico.mis-pacientes')" variant="secondary" class="w-full justify-center"><i class="fa-solid fa-users"></i> Mis Pacientes</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>

    <!-- MODAL NOTA -->
    <div id="noteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-soft-lg">
            <h2 class="mb-4 text-lg font-bold text-ink">Agregar Nota — <span id="pacienteName"></span></h2>
            <form id="noteForm" method="POST">
                @csrf
                <textarea name="nota" placeholder="Escribe la nota clínica aquí..." required class="h-36 w-full resize-y rounded-lg border border-slate-200 p-3 text-sm focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/10"></textarea>
                <div class="mt-4 flex gap-3">
                    <button type="button" onclick="closeNoteModal()" class="flex-1 rounded-lg bg-slate-100 px-4 py-2.5 text-sm font-semibold text-ink hover:bg-slate-200">Cancelar</button>
                    <button type="submit" class="flex-1 rounded-lg bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600">Guardar Nota</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL RECETA -->
    <div id="recetaModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-soft-lg">
            <h2 class="mb-4 text-lg font-bold text-ink">Nueva Receta — <span id="pacienteNameReceta"></span></h2>
            <form id="recetaForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink">Medicamentos *</label>
                    <textarea name="medicamentos" required class="h-24 w-full resize-y rounded-lg border border-slate-200 p-3 text-sm focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/10" placeholder="Ej: Ibuprofeno 400mg, cada 8 horas por 5 días"></textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink">Indicaciones</label>
                    <textarea name="indicaciones" class="h-24 w-full resize-y rounded-lg border border-slate-200 p-3 text-sm focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/10" placeholder="Reposo, aplicar hielo, etc."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRecetaModal()" class="flex-1 rounded-lg bg-slate-100 px-4 py-2.5 text-sm font-semibold text-ink hover:bg-slate-200">Cancelar</button>
                    <button type="submit" class="flex-1 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">Guardar Receta</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openNoteModal(citaId, pacienteName) {
            document.getElementById('noteModal').classList.remove('hidden');
            document.getElementById('noteModal').classList.add('flex');
            document.getElementById('pacienteName').textContent = pacienteName;
            document.getElementById('noteForm').action = '{{ route("medico.agregar-nota", ":id") }}'.replace(':id', citaId);
        }
        function closeNoteModal() {
            document.getElementById('noteModal').classList.add('hidden');
            document.getElementById('noteModal').classList.remove('flex');
            document.getElementById('noteForm').reset();
        }

        function openRecetaModal(citaId, pacienteName) {
            document.getElementById('recetaModal').classList.remove('hidden');
            document.getElementById('recetaModal').classList.add('flex');
            document.getElementById('pacienteNameReceta').textContent = pacienteName;
            document.getElementById('recetaForm').action = '{{ route("medico.guardar-receta", ":id") }}'.replace(':id', citaId);
        }
        function closeRecetaModal() {
            document.getElementById('recetaModal').classList.add('hidden');
            document.getElementById('recetaModal').classList.remove('flex');
            document.getElementById('recetaForm').reset();
        }
    </script>
</x-layouts.internal>
