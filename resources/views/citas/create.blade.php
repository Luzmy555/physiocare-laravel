<x-layouts.internal :title="'Agendar Cita - FisioCare Ayla'">
    <x-ui.page-header title="Agendar Cita" subtitle="Reserva tu consulta de fisioterapia en FisioCare Ayla" />

    @if (session('errors') && session('errors')->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul class="mt-1 list-disc pl-5">
                @foreach (session('errors')->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-ui.card class="mx-auto max-w-2xl">
        <form action="{{ route('citas.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <p class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-400">Datos de la Cita</p>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        @if(Auth::user() && Auth::user()->rol === 'paciente')
                            <x-ui.input type="text" name="paciente_display" label="Paciente *" :value="Auth::user()->name" disabled />
                            <input type="hidden" name="paciente_id" value="{{ Auth::user()->paciente->id }}">
                        @else
                            <x-ui.select name="paciente_id" label="Paciente *" required>
                                <option value="">Selecciona un paciente</option>
                                @foreach ($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nombre ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </x-ui.select>
                        @endif
                    </div>
                    <x-ui.select name="fisioterapeuta_id" label="Fisioterapeuta *" required>
                        <option value="">Selecciona un fisioterapeuta</option>
                        @foreach ($fisioterapeutas as $fisioterapeuta)
                            <option value="{{ $fisioterapeuta->id }}" {{ old('fisioterapeuta_id') == $fisioterapeuta->id ? 'selected' : '' }}>
                                {{ $fisioterapeuta->nombre ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.select name="especialidad_id" label="Especialidad *" required>
                        <option value="">Selecciona una especialidad</option>
                        @foreach ($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}" {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                                {{ $especialidad->nombre }}
                            </option>
                        @endforeach
                    </x-ui.select>
                </div>
            </div>

            <div>
                <p class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-400">Fecha y Hora</p>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-ui.input type="date" name="fecha" label="Fecha *" :value="old('fecha')" required />
                    <x-ui.input type="time" name="hora" label="Hora *" :value="old('hora')" required />
                </div>
            </div>

            <div>
                <p class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-400">Motivo de la Cita</p>
                <x-ui.textarea name="motivo" label="Motivo *" rows="4" required placeholder="Describe brevemente el motivo de tu cita...">{{ old('motivo') }}</x-ui.textarea>
            </div>

            <div>
                <p class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-400">Estado</p>
                <x-ui.select name="estado" required>
                    <option value="pendiente" {{ old('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmada" {{ old('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </x-ui.select>
            </div>

            <div class="flex gap-3 border-t border-slate-100 pt-6">
                <x-ui.button type="submit" class="flex-1 justify-center">Confirmar Cita</x-ui.button>
                <x-ui.button :href="route('citas.index')" variant="secondary" class="flex-1 justify-center">Cancelar</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.internal>
