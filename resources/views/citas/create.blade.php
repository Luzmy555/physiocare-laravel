<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - FisioCare Ayla</title>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <style>
        .booking-container {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0, 102, 204, 0.05), rgba(0, 212, 170, 0.05));
            padding: 40px 20px;
            margin-top: 60px;
        }

        .booking-card {
            background: var(--white);
            border-radius: 16px;
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            max-width: 600px;
            margin: 0 auto;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .booking-header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #126077;
        }

        .booking-header p {
            color: var(--gray-text);
            font-size: 16px;
        }

        .form-grid {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .form-group {
            width: 100%;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group label,
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            text-align: center;
        }

        .form-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin-top: 2.5rem;
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

        input[type="date"],
        input[type="time"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--gray-medium);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: var(--white);
        }

        input[type="date"]:focus,
        input[type="time"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        select {
            cursor: pointer;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 0.5rem;
            display: block;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert ul li {
            margin-bottom: 0.25rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
        }

        .btn-submit {
            flex: 1;
            padding: 14px;
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

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 102, 204, 0.4);
        }

        .btn-cancel {
            flex: 1;
            padding: 14px;
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

        @media (max-width: 640px) {
            .booking-card {
                padding: 2rem;
            }

            .booking-header h1 {
                font-size: 24px;
            }

            .form-grid {
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
    <div class="booking-container">
        <div class="booking-card">
            <div class="booking-header">
                <h1>Agendar Cita</h1>
                <p>Reserva tu consulta de fisioterapia en FisioCare Ayla</p>
            </div>

            @if (session('errors') && session('errors')->any())
            <div class="alert alert-danger">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach (session('errors')->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                <!-- SECCIÓN: DATOS DE LA CITA -->
                <div class="form-section">
                    <div class="section-title">Datos de la Cita</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="paciente_id">Paciente *</label>
                            @if(Auth::user() && Auth::user()->rol === 'paciente')
                                <input type="text" value="{{ Auth::user()->name }}" class="form-control" disabled>
                                <input type="hidden" name="paciente_id" value="{{ Auth::user()->paciente->id }}">
                            @else
                                <select id="paciente_id" name="paciente_id" required>
                                    <option value="">Selecciona un paciente</option>
                                    @foreach ($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->usuario->nombre ?? 'N/A' }}
                                    </option>
                                    @endforeach
                                </select>
                            @endif
                            @error('paciente_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="fisioterapeuta_id">Fisioterapeuta *</label>
                            <select id="fisioterapeuta_id" name="fisioterapeuta_id" required>
                                <option value="">Selecciona un fisioterapeuta</option>
                                @foreach ($fisioterapeutas as $fisioterapeuta)
                                <option value="{{ $fisioterapeuta->id }}" {{ old('fisioterapeuta_id') == $fisioterapeuta->id ? 'selected' : '' }}>
                                    {{ $fisioterapeuta->usuario->nombre ?? 'N/A' }}
                                </option>
                                @endforeach
                            </select>
                            @error('fisioterapeuta_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- SECCIÓN: FECHA Y HORA -->
                <div class="form-section">
                    <div class="section-title">Fecha y Hora</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fecha_cita">Fecha *</label>
                            <input type="date" id="fecha_cita" name="fecha_cita" value="{{ old('fecha_cita') }}" required>
                            @error('fecha_cita')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hora_cita">Hora *</label>
                            <input type="time" id="hora_cita" name="hora_cita" value="{{ old('hora_cita') }}" required>
                            @error('hora_cita')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- SECCIÓN: MOTIVO -->
                <div class="form-section">
                    <div class="section-title">Motivo de la Cita</div>
                    <div class="form-grid full">
                        <div class="form-group">
                            <label for="motivo">Motivo *</label>
                            <textarea id="motivo" name="motivo" required placeholder="Describe brevemente el motivo de tu cita...">{{ old('motivo') }}</textarea>
                            @error('motivo')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- SECCIÓN: ESTADO -->
                <div class="form-section">
                    <div class="section-title">Estado</div>
                    <div class="form-grid full">
                        <div class="form-group">
                            <select id="estado" name="estado" required>
                                <option value="pendiente" {{ old('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('estado')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Confirmar Cita</button>
                    <a href="{{ route('citas.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
