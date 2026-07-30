<x-layouts.internal :title="'Pacientes - FisioCare Ayla'">
    <x-ui.page-header title="Pacientes" subtitle="Directorio de pacientes registrados">
        <x-slot:actions>
            <x-ui.button :href="route('pacientes.create')"><i class="fa-solid fa-plus"></i> Nuevo Paciente</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    @if ($message = Session::get('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ $message }}
        </div>
    @endif

    @if ($pacientes->count() > 0)
        <x-ui.table>
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Cédula</th>
                    <th class="px-6 py-3">Fecha Nacimiento</th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3">Sexo</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($pacientes as $paciente)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold text-ink">{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $paciente->cedula ?? '—' }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $paciente->fecha_nacimiento }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $paciente->telefono }}</td>
                        <td class="px-6 py-3 text-slate-600">{{ $paciente->sexo == 'M' ? 'Masculino' : 'Femenino' }}</td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('pacientes.show', $paciente->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-600">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('pacientes.edit', $paciente->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-600">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" onsubmit="return confirm('¿Está seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table>
    @else
        <x-ui.card>
            <x-ui.empty-state icon="fa-user-injured" title="No hay pacientes registrados" />
        </x-ui.card>
    @endif

    <div class="mt-6 flex justify-center">
        {{ $pacientes->links() }}
    </div>
</x-layouts.internal>
