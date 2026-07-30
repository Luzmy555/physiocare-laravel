<x-layouts.internal :title="'Historial Clínico - FisioCare Ayla'">
    <x-ui.page-header title="Detalles del Historial Clínico">
        <x-slot:actions>
            <x-ui.button :href="route('historiales.edit', $historial->id)" variant="outline"><i class="fa-solid fa-pen"></i> Editar</x-ui.button>
            <x-ui.button :href="route('historiales.index')" variant="secondary">Volver</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <x-ui.card>
        <div class="mb-6 grid grid-cols-1 gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
            <p><strong class="text-ink">Paciente:</strong> <span class="text-slate-600">{{ $historial->paciente->nombre ?? 'N/A' }} {{ $historial->paciente->apellido ?? '' }}</span></p>
            <p><strong class="text-ink">Fisioterapeuta:</strong> <span class="text-slate-600">{{ $historial->fisioterapeuta->nombre ?? 'N/A' }} {{ $historial->fisioterapeuta->apellido ?? '' }}</span></p>
            <p><strong class="text-ink">Email Paciente:</strong> <span class="text-slate-600">{{ $historial->paciente->correo ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Especialidad:</strong> <span class="text-slate-600">{{ $historial->fisioterapeuta->especialidad->nombre ?? 'N/A' }}</span></p>
            <p><strong class="text-ink">Registrado:</strong> <span class="text-slate-600">{{ $historial->created_at->format('d/m/Y H:i') }}</span></p>
        </div>

        <div class="space-y-4 border-t border-slate-100 pt-4 text-sm">
            <div>
                <p class="mb-1 font-semibold text-ink">Descripción</p>
                <p class="text-slate-600">{{ $historial->observaciones }}</p>
            </div>
            <div>
                <p class="mb-1 font-semibold text-ink">Diagnóstico</p>
                <p class="text-slate-600">{{ $historial->diagnostico }}</p>
            </div>
            <div>
                <p class="mb-1 font-semibold text-ink">Tratamiento</p>
                <p class="text-slate-600">{{ $historial->tratamiento }}</p>
            </div>
        </div>
    </x-ui.card>

    <x-ui.card class="mt-6">
        <p class="mb-4 font-poppins text-base font-bold text-ink"><i class="fa-solid fa-paperclip mr-2 text-primary"></i>Archivos Adjuntos</p>

        @if ($historial->archivos->count() > 0)
            <div class="mb-6 divide-y divide-slate-100 rounded-xl border border-slate-100">
                @foreach ($historial->archivos as $archivo)
                    @php
                        $icon = match(true) {
                            $archivo->mime_type === 'application/pdf' => 'fa-file-pdf',
                            str_starts_with($archivo->mime_type, 'image/') => 'fa-file-image',
                            str_contains($archivo->mime_type, 'word') => 'fa-file-word',
                            default => 'fa-file',
                        };
                        $kb = $archivo->tamano / 1024;
                        $tamanoLegible = $kb >= 1024 ? number_format($kb / 1024, 1) . ' MB' : number_format($kb, 0) . ' KB';
                    @endphp
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <div class="flex min-w-0 items-center gap-3">
                            <i class="fa-solid {{ $icon }} text-lg text-primary"></i>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-ink">{{ $archivo->nombre_original }}</p>
                                <p class="text-xs text-slate-400">
                                    {{ $tamanoLegible }}
                                    @if($archivo->subido_por) &middot; Subido por {{ $archivo->subido_por }} @endif
                                    &middot; {{ $archivo->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex shrink-0 gap-2">
                            <a href="{{ route('historiales.archivos.download', $archivo->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-600">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            <form action="{{ route('historiales.archivos.destroy', $archivo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este archivo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mb-6 text-sm text-slate-400">Aún no hay archivos adjuntos.</p>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('historiales.archivos.store', $historial->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:items-end">
            @csrf
            <div class="flex-1">
                <label class="mb-1.5 block text-sm font-semibold text-ink">Subir archivo (PDF, imagen o Word — máx. 10MB)</label>
                <input type="file" name="archivo" required class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-ink shadow-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-primary">
            </div>
            <x-ui.button type="submit"><i class="fa-solid fa-upload"></i> Subir</x-ui.button>
        </form>
    </x-ui.card>
</x-layouts.internal>
