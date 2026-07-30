<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agendar Cita - FisioCare Ayla</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter text-ink antialiased">
    <header class="fixed inset-x-0 top-0 z-20 border-b border-slate-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="FisioCare Ayla" class="h-10 w-10 rounded-lg object-cover">
                <div class="leading-tight">
                    <p class="font-poppins text-sm font-bold text-ink">FisioCare Ayla</p>
                    <p class="text-xs text-slate-400">Clínica de Fisioterapia</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="rounded-lg border-2 border-primary px-4 py-2 text-sm font-semibold text-primary hover:bg-primary/5">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-dark">Registrarse</a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-dark">Cerrar sesión</button>
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <div class="min-h-screen bg-gradient-to-br from-primary/5 to-accent/5 px-4 pb-16 pt-28">
        <div class="mx-auto max-w-3xl">
            <div class="mb-8 text-center">
                <h1 class="font-poppins text-3xl font-bold text-ink sm:text-4xl">Agendar Cita</h1>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">Reserva tu consulta de fisioterapia en FisioCare Ayla de forma rápida y segura</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft-lg sm:p-10">
                <div class="mb-8 rounded-lg border-l-4 border-primary bg-blue-50 p-4 text-sm text-ink">
                    <strong class="mb-1 block text-primary">Información Importante</strong>
                    Completa todos los campos para agendar tu cita. Recibirás un correo de confirmación con los detalles.
                </div>

                <form action="{{ route('citas.publicas.store') }}" method="POST" id="citasForm" class="space-y-10">
                    @csrf

                    <div>
                        <p class="mb-5 border-b-2 border-primary pb-2 text-xs font-bold uppercase tracking-wide text-primary">1. Datos Personales</p>
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <x-ui.input type="text" name="cedula" label="Cédula" :value="old('cedula')" placeholder="Ej: 1234567890" required />
                            <x-ui.input type="email" name="correo" label="Correo" :value="old('correo')" placeholder="tu@correo.com" required />
                            <x-ui.input type="text" name="nombres" label="Nombres" :value="old('nombres')" placeholder="Tu nombre" required />
                            <x-ui.input type="text" name="apellidos" label="Apellidos" :value="old('apellidos')" placeholder="Tu apellido" required />
                            <x-ui.input type="tel" name="telefono" label="Teléfono" :value="old('telefono')" placeholder="+58 412-123-4567" required />
                        </div>
                    </div>

                    <div>
                        <p class="mb-5 border-b-2 border-primary pb-2 text-xs font-bold uppercase tracking-wide text-primary">2. Especialidad y Profesional</p>
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <x-ui.select name="especialidad_id" label="Especialidad" required onchange="cargarFisioterapeutas()">
                                <option value="">-- Selecciona una especialidad --</option>
                                @foreach ($especialidades as $esp)
                                    <option value="{{ $esp->id }}" {{ old('especialidad_id') == $esp->id ? 'selected' : '' }}>
                                        {{ $esp->nombre }}
                                    </option>
                                @endforeach
                            </x-ui.select>

                            <x-ui.select name="fisioterapeuta_id" label="Fisioterapeuta" required>
                                <option value="">-- Primero selecciona una especialidad --</option>
                                @foreach ($fisioterapeutas as $fis)
                                    <option value="{{ $fis->id }}"
                                        data-especialidad="{{ $fis->especialidad_id }}"
                                        {{ old('fisioterapeuta_id') == $fis->id ? 'selected' : '' }}>
                                        {{ $fis->nombre }} {{ $fis->apellido ?? '' }}
                                    </option>
                                @endforeach
                            </x-ui.select>
                        </div>
                    </div>

                    <div>
                        <p class="mb-5 border-b-2 border-primary pb-2 text-xs font-bold uppercase tracking-wide text-primary">3. Fecha y Hora de la Cita</p>
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <x-ui.input type="date" name="fecha_cita" label="Fecha" :value="old('fecha_cita')" required />
                            <x-ui.input type="time" name="hora_cita" label="Hora" :value="old('hora_cita')" required />
                        </div>
                    </div>

                    <div>
                        <p class="mb-5 border-b-2 border-primary pb-2 text-xs font-bold uppercase tracking-wide text-primary">4. Motivo de la Consulta</p>
                        <x-ui.textarea name="motivo" label="Describe brevemente tu motivo de consulta" rows="4" required placeholder="Cuéntanos qué tipo de fisioterapia necesitas...">{{ old('motivo') }}</x-ui.textarea>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row">
                        <x-ui.button type="submit" class="flex-1 justify-center">Confirmar Cita</x-ui.button>
                        <x-ui.button href="/" variant="secondary" class="flex-1 justify-center">Cancelar</x-ui.button>
                    </div>

                    <div class="hidden items-center justify-center gap-2 pt-2 text-sm text-primary" id="loadingIndicator">
                        <span class="h-5 w-5 animate-spin rounded-full border-2 border-primary/20 border-t-primary"></span>
                        Procesando tu cita...
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function cargarFisioterapeutas() {
            const especialidadId = document.getElementById('especialidad_id').value;
            const fisioterapeutaSelect = document.getElementById('fisioterapeuta_id');

            fisioterapeutaSelect.innerHTML = '<option value="">-- Selecciona un fisioterapeuta --</option>';
            if (!especialidadId) return;

            let baseUrl = window.location.pathname.includes('/public/') ? '/fisiocare-ayla/public' : '';
            fetch(`${baseUrl}/api/fisioterapeutas/${especialidadId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        fisioterapeutaSelect.innerHTML += '<option value="">No hay fisioterapeutas disponibles para esa especialidad</option>';
                    } else {
                        data.forEach(fis => {
                            fisioterapeutaSelect.innerHTML += `<option value="${fis.id}">${fis.nombre} ${fis.apellido ?? ''}</option>`;
                        });
                    }
                });
        }

        document.getElementById('especialidad_id').addEventListener('change', cargarFisioterapeutas);

        document.getElementById('fecha_cita').addEventListener('change', function() {
            const hoy = new Date().toISOString().split('T')[0];
            if (this.value < hoy) {
                this.value = '';
                alert('No puedes agendar citas en el pasado');
            }
        });

        document.getElementById('citasForm').addEventListener('submit', function(e) {
            document.getElementById('loadingIndicator').classList.remove('hidden');
            document.getElementById('loadingIndicator').classList.add('flex');
        });

        window.addEventListener('load', function() {
            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_cita').setAttribute('min', hoy);
        });
    </script>
</body>
</html>
