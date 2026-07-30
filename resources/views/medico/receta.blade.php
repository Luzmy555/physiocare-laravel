<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta - FisioCare Ayla</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-inter text-ink antialiased">
    <div class="mx-auto max-w-2xl px-4 py-10">
        <div class="print:hidden mb-6 flex items-center justify-between">
            <a href="{{ route('medico.mis-citas') }}" class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:text-accent-dark">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-dark">
                <i class="fa-solid fa-print"></i> Imprimir
            </button>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-10 shadow-sm print:border-0 print:shadow-none">
            <div class="mb-8 flex items-center justify-between border-b border-slate-100 pb-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="FisioCare Ayla" class="h-12 w-12 rounded-lg object-cover">
                    <div>
                        <p class="font-poppins text-lg font-bold text-ink">FisioCare Ayla</p>
                        <p class="text-xs text-slate-400">Receta médica</p>
                    </div>
                </div>
                <p class="text-sm text-slate-500">{{ $cita->fecha_cita->format('d/m/Y') }}</p>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
                <p><strong class="text-ink">Paciente:</strong> <span class="text-slate-600">{{ $cita->nombres }} {{ $cita->apellidos }}</span></p>
                <p><strong class="text-ink">Cédula:</strong> <span class="text-slate-600">{{ $cita->cedula }}</span></p>
                <p><strong class="text-ink">Especialidad:</strong> <span class="text-slate-600">{{ $cita->especialidad->nombre ?? 'N/A' }}</span></p>
                <p><strong class="text-ink">Fisioterapeuta:</strong> <span class="text-slate-600">{{ $receta->fisioterapeuta->nombre }} {{ $receta->fisioterapeuta->apellido }}</span></p>
            </div>

            <div class="mb-8">
                <p class="mb-2 text-xs font-bold uppercase tracking-wide text-primary">Rx — Medicamentos</p>
                <p class="whitespace-pre-line rounded-lg bg-slate-50 p-4 text-sm text-ink">{{ $receta->medicamentos }}</p>
            </div>

            @if ($receta->indicaciones)
                <div class="mb-8">
                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-primary">Indicaciones</p>
                    <p class="whitespace-pre-line rounded-lg bg-slate-50 p-4 text-sm text-ink">{{ $receta->indicaciones }}</p>
                </div>
            @endif

            <div class="mt-16 flex justify-center">
                <div class="w-64 border-t border-slate-300 pt-2 text-center">
                    <p class="text-sm text-slate-500">{{ $receta->fisioterapeuta->nombre }} {{ $receta->fisioterapeuta->apellido }}</p>
                    <p class="text-xs text-slate-400">N.º Colegiado: {{ $receta->fisioterapeuta->numero_colegiado }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
