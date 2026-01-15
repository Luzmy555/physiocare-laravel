<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - FisioCare Ayla</title>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <style>
        .booking-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 212, 170, 0.05));
            padding: 60px 20px 40px;
        }

        .booking-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .booking-header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #0c457eff;
            margin-bottom: 0.75rem;
        }

        .booking-header p {
            color: var(--gray-text);
            font-size: 16px;
            max-width: 500px;
            margin: 0 auto;
        }

        .booking-card {
            background: var(--white);
            border-radius: 16px;
            padding: 3rem;
            box-shadow: var(--shadow-lg);
        }

        .form-section {
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-grid.full {
            grid-template-columns: 1fr;
        }

        .form-grid.triple {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .form-group {
            margin-bottom: 0;
        }

        label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.75rem;
            font-size: 14px;
        }

        .label-required::after {
            content: " *";
            color: #ef4444;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: var(--white);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        input[type="text"]:invalid,
        input[type="email"]:invalid,
        input[type="tel"]:invalid,
        input[type="date"]:invalid,
        input[type="time"]:invalid,
        select:invalid,
        textarea:invalid {
            border-color: #ef4444;
        }

        select {
            cursor: pointer;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 0.5rem;
            display: block;
            font-weight: 500;
        }

        .alert {
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 14px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert ul li {
            margin-bottom: 0.5rem;
        }

        .info-box {
            background: #f0f9ff;
            border-left: 4px solid var(--primary);
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 14px;
            color: #0c4a6e;
        }

        .info-box strong {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn-submit {
            flex: 1;
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 102, 204, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-cancel {
            flex: 1;
            padding: 14px 24px;
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background: var(--primary);
            color: var(--white);
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
            color: var(--primary);
        }

        .loading.show {
            display: block;
        }

        .spinner {
            border: 3px solid rgba(0, 102, 204, 0.1);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 0.8s linear infinite;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .booking-card {
                padding: 2rem;
            }

            .booking-header h1 {
                font-size: 28px;
            }

            .form-grid,
            .form-grid.triple {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    @include('layouts.navbar_interno')

    <div class="booking-wrapper">
        <div class="booking-container">
            <div class="booking-header">
                <h1>Agendar Cita</h1>
                <p>Reserva tu consulta de fisioterapia en FisioCare Ayla de forma rápida y segura</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>⚠️ Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="booking-card">
                <div class="info-box">
                    <strong>💡 Información Importante:</strong>
                    Completa todos los campos para agendar tu cita. Recibirás un correo de confirmación con los detalles.
                </div>

                <form action="{{ route('citas.publicas.store') }}" method="POST" id="citasForm">
                    @csrf

                    <!-- SECCIÓN: DATOS PERSONALES -->
                    <div class="form-section">
                        <div class="section-title">1. Datos Personales</div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="cedula" class="label-required">Cédula</label>
                                <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}"
                                    placeholder="Ej: 1234567890" required>
                                @error('cedula')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="correo" class="label-required">Correo</label>
                                <input type="email" id="correo" name="correo" value="{{ old('correo') }}"
                                    placeholder="tu@correo.com" required>
                                @error('correo')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombres" class="label-required">Nombres</label>
                                <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}"
                                    placeholder="Tu nombre" required>
                                @error('nombres')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="apellidos" class="label-required">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}"
                                    placeholder="Tu apellido" required>
                                @error('apellidos')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="telefono" class="label-required">Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                    placeholder="+58 412-123-4567" required>
                                @error('telefono')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN: ESPECIALIDAD Y DOCTOR -->
                    <div class="form-section">
                        <div class="section-title">2. Especialidad y Profesional</div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="especialidad_id" class="label-required">Especialidad</label>
                                <select id="especialidad_id" name="especialidad_id" required onchange="cargarFisioterapeutas()">
                                    <option value="">-- Selecciona una especialidad --</option>
                                    @foreach ($especialidades as $esp)
                                    <option value="{{ $esp->id }}" {{ old('especialidad_id') == $esp->id ? 'selected' : '' }}>
                                        {{ $esp->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('especialidad_id')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="fisioterapeuta_id" class="label-required">Fisioterapeuta</label>
                                <select id="fisioterapeuta_id" name="fisioterapeuta_id" required>
                                    <option value="">-- Primero selecciona una especialidad --</option>
                                    @foreach ($fisioterapeutas as $fis)
                                    <option value="{{ $fis->id }}"
                                        data-especialidad="{{ $fis->especialidad_id }}"
                                        {{ old('fisioterapeuta_id') == $fis->id ? 'selected' : '' }}>
                                        {{ $fis->nombre }} {{ $fis->apellido ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('fisioterapeuta_id')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN: CITA -->
                    <div class="form-section">
                        <div class="section-title">3. Fecha y Hora de la Cita</div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="fecha_cita" class="label-required">Fecha</label>
                                <input type="date" id="fecha_cita" name="fecha_cita" value="{{ old('fecha_cita') }}" required>
                                @error('fecha_cita')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="hora_cita" class="label-required">Hora</label>
                                <input type="time" id="hora_cita" name="hora_cita" value="{{ old('hora_cita') }}" required>
                                @error('hora_cita')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN: MOTIVO -->
                    <div class="form-section">
                        <div class="section-title">4. Motivo de la Consulta</div>

                        <div class="form-grid full">
                            <div class="form-group">
                                <label for="motivo" class="label-required">Describe brevemente tu motivo de consulta</label>
                                <textarea id="motivo" name="motivo" placeholder="Cuéntanos qué tipo de fisioterapia necesitas..." required>{{ old('motivo') }}</textarea>
                                @error('motivo')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">✓ Confirmar Cita</button>
                        <a href="/" class="btn-cancel">Cancelar</a>
                    </div>

                    <div class="loading" id="loadingIndicator">
                        <div class="spinner"></div>
                        <span>Procesando tu cita...</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        // Filtrar fisioterapeutas solo por especialidad (sin horario)
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

        // Validar fecha mínima
        document.getElementById('fecha_cita').addEventListener('change', function() {
            const hoy = new Date().toISOString().split('T')[0];
            if (this.value < hoy) {
                this.value = '';
                alert('No puedes agendar citas en el pasado');
            }
        });

        // Mostrar indicador de carga al enviar
        document.getElementById('citasForm').addEventListener('submit', function(e) {
            document.getElementById('loadingIndicator').classList.add('show');
        });

        // Establecer fecha mínima a hoy
        window.addEventListener('load', function() {
            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_cita').setAttribute('min', hoy);
        });
    </script>
</body>
</html>
