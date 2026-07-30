<x-layouts.internal :title="'Mis Citas - FisioCare Ayla'">
    <x-ui.page-header title="Mis Citas" subtitle="Gestión de tus citas médicas" />

    <x-ui.card class="mb-6">
        <div class="max-w-xs">
            <x-ui.select name="estado" label="Estado" onchange="window.location='?estado='+this.value">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('estado')=='pendiente'?'selected':'' }}>Pendiente</option>
                <option value="confirmada" {{ request('estado')=='confirmada'?'selected':'' }}>Confirmada</option>
                <option value="completada" {{ request('estado')=='completada'?'selected':'' }}>Completada</option>
                <option value="cancelada" {{ request('estado')=='cancelada'?'selected':'' }}>Cancelada</option>
            </x-ui.select>
        </div>
    </x-ui.card>

    @if($citas->count())
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Paciente</th>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Hora</th>
                    <th class="px-6 py-3">Especialidad</th>
                    <th class="px-6 py-3">Motivo</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($citas as $cita)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3">
                            <p class="font-semibold text-ink">{{ $cita->nombres }} {{ $cita->apellidos }}</p>
                            <p class="text-xs text-slate-400">{{ $cita->correo }}</p>
                        </td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->fecha_cita->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->hora_cita }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $cita->especialidad->nombre }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ Str::limit($cita->motivo, 40) }}</td>
                        <td class="px-6 py-3">
                            <x-ui.badge :color="match($cita->estado) { 'confirmada' => 'green', 'completada' => 'green', 'cancelada' => 'red', default => 'amber' }">
                                {{ ucfirst($cita->estado) }}
                            </x-ui.badge>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex flex-wrap gap-2">
                                @if($cita->estado === 'pendiente')
                                    <form action="{{ route('medico.confirmar-cita', $cita->id) }}" method="POST">
                                        @csrf
                                        <button class="inline-flex items-center gap-1 rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-600">
                                            <i class="fa-solid fa-check"></i> Confirmar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.citas.cancelar', $cita->id) }}" method="POST">
                                        @csrf
                                        <button class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600" onclick="return confirm('¿Cancelar esta cita?')">
                                            <i class="fa-solid fa-xmark"></i> Cancelar
                                        </button>
                                    </form>
                                @endif
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table>

        <div class="mt-6">{{ $citas->links() }}</div>
    @else
        <x-ui.card>
            <x-ui.empty-state icon="fa-calendar-days" title="No tienes citas registradas" />
        </x-ui.card>
    @endif

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
