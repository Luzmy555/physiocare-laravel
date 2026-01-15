@extends('layouts.app', ['showNavbar' => false])


{{-- Dashboard styles moved to public/assets/css/home.css --}}

@section('content')
<div class="dashboard-wrapper">
        <!-- SIDEBAR -->
        <aside class="dashboard-sidebar">
            <div class="sidebar-profile">
                <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-role">
                    @if ($rol === 'admin')
                        Administrador
                    @elseif ($rol === 'fisioterapeuta')
                        Fisioterapeuta
                    @else
                        Paciente
                    @endif
                </div>
            </div>

            <ul class="sidebar-menu">
                @if ($rol === 'admin')
                    <li><a href="#" class="active">🏠 Panel</a></li>
                    <li><a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a></li>
                    <li><a href="{{ route('admin.medicos.index') }}">👨‍⚕️ Fisioterapeutas</a></li>
                    <li><a href="{{ route('admin.citas.index') }}">📋 Citas</a></li>
                    <li><a href="#">📊 Estadísticas</a></li>
                    <li><a href="{{ route('profile.edit') }}">👤 Mi Perfil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Cerrar Sesión</a></li>
                @elseif ($rol === 'fisioterapeuta')
                    <li><a href="#" class="active">🏠 Inicio</a></li>
                    <li><a href="{{ route('medico.mis-citas') }}">📅 Mis Citas</a></li>
                    <li><a href="{{ route('medico.mis-pacientes') }}">📋 Historiales Clínicos</a></li>
                    <li><a href="{{ route('medico.mi-horario') }}">🕒 Mi Horario</a></li>
                    <li><a href="#">🔔 Notificaciones</a></li>
                    <li><a href="{{ route('profile.edit') }}">👤 Mi Perfil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Cerrar Sesión</a></li>
                @else
                    <li><a href="#" class="active">🏠 Inicio</a></li>
                    <li><a href="{{ route('citas.create') }}">📅 Agendar Cita</a></li>
                    <li><a href="{{ route('profile.edit') }}">👤 Mi Perfil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Cerrar Sesión</a></li>
                @endif
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="dashboard-content">
            @if ($rol === 'fisioterapeuta')
            <div class="page-header">
                <div>
                    <h1 class="page-title" style="font-size:2rem; font-weight:800; color:#0f172a; margin-bottom:.25rem;">
                        Bienvenido/a, Dr. {{ $fisioterapeuta->nombre }} {{ $fisioterapeuta->apellido }}
                    </h1>
                    <p class="page-subtitle" style="font-size:1.1rem; color:#0c457e; margin-bottom:0.5rem;">
                        Especialidad: {{ $fisioterapeuta->especialidad->nombre ?? 'Sin especialidad' }}<br>
                        Última sesión: {{ $ultimaSesion ?? 'Sin registros' }}
                    </p>
                    <div style="margin-top:1.5rem; font-size:1.15rem; color:#0c457e; background:#e0f2fe; border-radius:10px; padding:1rem 1.5rem;">
                        Hoy tienes <b>{{ $totalCitasHoy }}</b> citas programadas.<br>
                        Tu próxima cita es a las <b>{{ $proximaCitaHora }}</b> con <b>{{ $proximaCitaPaciente }}</b>.
                    </div>
                </div>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header"><div class="stat-label">Citas pendientes</div><div class="stat-icon warning">⏳</div></div>
                    <div class="stat-value">{{ $cantidadPendientes }}</div>
                    <div class="stat-change">Por atender</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header"><div class="stat-label">Pacientes atendidos este mes</div><div class="stat-icon success">👥</div></div>
                    <div class="stat-value">{{ $totalPacientesMes }}</div>
                    <div class="stat-change">En el mes actual</div>
                </div>
            </div>
            <!-- Agenda del día -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">🗓️ Agenda del Día</div>
                </div>
                <table class="table" style="width:100%; margin-top:1rem;">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($citasHoy as $cita)
                        <tr>
                            <td>{{ $cita->hora_cita }}</td>
                            <td>{{ $cita->nombres }} {{ $cita->apellidos }}</td>
                            <td>{{ $cita->motivo }}</td>
                            <td>{{ ucfirst($cita->estado) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Historiales clínicos recientes -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">📋 Historiales Clínicos Recientes</div>
                </div>
                <ul>
                    @foreach ($historialesRecientes as $historial)
                        <li>
                            <b>{{ $historial->paciente->nombre }} {{ $historial->paciente->apellido }}</b> - {{ $historial->descripcion }} <span style="color:#64748b;">({{ $historial->created_at->format('d/m/Y') }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Notificaciones recientes -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">🔔 Notificaciones Recientes</div>
                </div>
                <ul>
                    @foreach ($notificaciones as $noti)
                        <li>{{ $noti->mensaje }}</li>
                    @endforeach
                </ul>
            </div>
            @else
                <div class="page-header">
                    <div>
                        <h1 class="page-title">
                            @if ($rol === 'paciente')
                                Bienvenido, {{ Auth::user()->name }}
                            @elseif ($rol === 'admin')
                                Panel Administrativo
                            @elseif ($rol === 'fisioterapeuta')
                                Bienvenido, {{ Auth::user()->name }}
                            @else
                                Dashboard
                            @endif
                        </h1>
                        <p class="page-subtitle">
                            @if ($rol === 'paciente')
                                Gestiona tus citas y tu perfil
                            @elseif ($rol === 'admin')
                                Control total de la clínica
                            @endif
                        </p>
                    </div>
                    @if ($rol === 'paciente')
                        <a href="{{ route('citas.create') }}" class="btn-primary-outline">➕ Agendar Nueva Cita</a>
                    @elseif ($rol === 'admin')
                        <a href="#" class="btn-primary-outline">➕ Gestionar Sistema</a>
                        <a href="{{ route('admin.usuarios.index') }}" class="btn-primary-outline">⚙️ Panel de Gestión</a>
                    @endif
                </div>
            @endif

            <!-- ESTADÍSTICAS SEGÚN ROL -->
            <div class="stats-grid">
                @if ($rol === 'paciente')
                    <!-- STATS PARA PACIENTES -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Citas Totales</div>
                            <div class="stat-icon info">📊</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_totales'] ?? 0 }}</div>
                        <div class="stat-change">Todas tus citas agendadas</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Próximas Citas</div>
                            <div class="stat-icon warning">📅</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_proximas'] ?? 0 }}</div>
                        <div class="stat-change">Citas pendientes</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Completadas</div>
                            <div class="stat-icon success">✓</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_completadas'] ?? 0 }}</div>
                        <div class="stat-change">Citas finalizadas</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Canceladas</div>
                            <div class="stat-icon danger">✕</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_canceladas'] ?? 0 }}</div>
                        <div class="stat-change">Citas canceladas</div>
                    </div>

                @elseif ($rol === 'medico')
                    <!-- STATS PARA MÉDICOS -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Citas Totales</div>
                            <div class="stat-icon info">📊</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_totales'] ?? 0 }}</div>
                        <div class="stat-change">En tu historial</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Citas Hoy</div>
                            <div class="stat-icon warning">🔥</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_hoy'] ?? 0 }}</div>
                        <div class="stat-change">Por atender hoy</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Próximas</div>
                            <div class="stat-icon info">📅</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_proximas'] ?? 0 }}</div>
                        <div class="stat-change">Próximos días</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Pacientes Únicos</div>
                            <div class="stat-icon success">👥</div>
                        </div>
                        <div class="stat-value">{{ $stats['pacientes_unicos'] ?? 0 }}</div>
                        <div class="stat-change">Atendidos</div>
                    </div>

                @elseif ($rol === 'admin')
                    <!-- STATS PARA ADMIN -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Citas Totales</div>
                            <div class="stat-icon info">📊</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_totales'] ?? 0 }}</div>
                        <div class="stat-change">En el sistema</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Citas Hoy</div>
                            <div class="stat-icon warning">🔥</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_hoy'] ?? 0 }}</div>
                        <div class="stat-change">Programadas para hoy</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Pendientes</div>
                            <div class="stat-icon warning">⏳</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_pendientes'] ?? 0 }}</div>
                        <div class="stat-change">Por confirmar</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Confirmadas</div>
                            <div class="stat-icon success">✓</div>
                        </div>
                        <div class="stat-value">{{ $stats['citas_confirmadas'] ?? 0 }}</div>
                        <div class="stat-change">Confirmadas</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Pacientes</div>
                            <div class="stat-icon info">👥</div>
                        </div>
                        <div class="stat-value">{{ $stats['pacientes_unicos'] ?? 0 }}</div>
                        <div class="stat-change">Únicos</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-label">Fisioterapeutas</div>
                            <div class="stat-icon success">👨‍⚕️</div>
                        </div>
                        <div class="stat-value">{{ $stats['fisioterapeutas_totales'] ?? 0 }}</div>
                        <div class="stat-change">En plantilla</div>
                    </div>
                @endif
            </div>

            <!-- CONTENIDO ESPECÍFICO POR ROL -->
            @if ($rol === 'paciente')
                <!-- CITAS PROXIMAS PARA PACIENTES -->
                <div class="content-section">
                    <div class="section-header">
                        <div>
                            <div class="section-title">📅 Próximas Citas</div>
                            <p style="font-size: 13px; color: var(--gray-text); margin-top: 0.25rem;">
                                Tus citas programadas para los próximos días
                            </p>
                        </div>
                        <a href="/agendar-cita" class="btn-small">➕ Nueva Cita</a>
                    </div>

                    @php
                        $citasProximas = \App\Models\CitaPublica::where('correo', Auth::user()->email)
                            ->where('fecha_cita', '>=', today())
                            ->where('estado', '!=', 'cancelada')
                            ->orderBy('fecha_cita')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if ($citasProximas->count() > 0)
                        @foreach ($citasProximas as $cita)
                            <div class="cita-item">
                                <div class="cita-date">
                                    <div class="cita-day">{{ $cita->fecha_cita->format('d') }}</div>
                                    <div class="cita-month">{{ strtoupper($cita->fecha_cita->format('M')) }}</div>
                                </div>
                                <div class="cita-info">
                                    <div class="cita-title">{{ $cita->fisioterapeuta->nombre }} {{ $cita->fisioterapeuta->apellido }}</div>
                                    <div class="cita-details">
                                        <strong>{{ $cita->especialidad->nombre }}</strong> • {{ $cita->hora_cita }}
                                    </div>
                                    <div class="cita-details">{{ $cita->motivo }}</div>
                                    <span class="cita-status {{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <div class="empty-title">No tienes citas programadas</div>
                            <div class="empty-text">¡Agenda tu primera cita ahora!</div>
                            <a href="{{ route('citas.create') }}" class="btn-small">Agendar Cita</a>
                        </div>
                    @endif
                </div>

            @elseif ($rol === 'medico')
                <!-- CITAS DE HOY PARA MÉDICOS -->
                <div class="content-section">
                    <div class="section-header">
                        <div>
                            <div class="section-title">🔥 Citas de Hoy</div>
                            <p style="font-size: 13px; color: var(--gray-text); margin-top: 0.25rem;">
                                Pacientes programados para hoy
                            </p>
                        </div>
                    </div>

                    @if (isset($citasHoy) && $citasHoy->count() > 0)
                        @foreach ($citasHoy as $cita)
                            <div class="cita-item">
                                <div class="cita-date">
                                    <div class="cita-day" style="color: var(--warning);">{{ $cita->hora_cita }}</div>
                                    <div class="cita-month">Hora</div>
                                </div>
                                <div class="cita-info">
                                    <div class="cita-title">{{ $cita->nombres }} {{ $cita->apellidos }}</div>
                                    <div class="cita-details">
                                        📞 {{ $cita->telefono }} • 📧 {{ $cita->correo }}
                                    </div>
                                    <div class="cita-details">
                                        <strong>{{ $cita->especialidad->nombre }}</strong> - {{ $cita->motivo }}
                                    </div>
                                    <span class="cita-status {{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">😎</div>
                            <div class="empty-title">Sin citas hoy</div>
                            <div class="empty-text">¡Disfruta tu descanso!</div>
                        </div>
                    @endif
                </div>

            @elseif ($rol === 'admin')
                <!-- CITAS RECIENTES PARA ADMIN -->
                <div class="content-section">
                    <div class="section-header">
                        <div>
                            <div class="section-title">📋 Últimas Citas Agendadas</div>
                            <p style="font-size: 13px; color: var(--gray-text); margin-top: 0.25rem;">
                                Citas recientes en el sistema
                            </p>
                        </div>
                        <a href="#" class="btn-small">👁️ Ver Todas</a>
                    </div>

                    @if (isset($citasRecientes) && $citasRecientes->count() > 0)
                        @foreach ($citasRecientes as $cita)
                            <div class="cita-item">
                                <div class="cita-date">
                                    <div class="cita-day">{{ $cita->fecha_cita->format('d') }}</div>
                                    <div class="cita-month">{{ strtoupper($cita->fecha_cita->format('M')) }}</div>
                                </div>
                                <div class="cita-info">
                                    <div class="cita-title">{{ $cita->nombres }} {{ $cita->apellidos }}</div>
                                    <div class="cita-details">
                                        👨‍⚕️ {{ $cita->fisioterapeuta->nombre }} • 🏥 {{ $cita->especialidad->nombre }}
                                    </div>
                                    <div class="cita-details">{{ $cita->correo }}</div>
                                    <span class="cita-status {{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <div class="empty-title">No hay citas</div>
                        </div>
                    @endif
                </div>

                <!-- GESTIÓN RÁPIDA PARA ADMIN -->
                <div class="content-section">
                    <div class="section-header">
                        <div class="section-title">⚙️ Gestión del Sistema</div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn-usuarios">
                            👥 Gestionar Usuarios
                        </a>
                        <a href="{{ route('admin.medicos.index') }}" class="btn-medicos">
                            👨‍⚕️ Gestionar Médicos
                        </a>
                        <a href="{{ route('admin.citas.index') }}" class="btn-citas">
                            📊 Ver Citas
                        </a>
                        <a href="#" class="btn-config">
                            ⚙️ Configuración
                        </a>
                    </div>
                </div>
            @endif

            <!-- ACCIONES RÁPIDAS -->
            @if ($rol === 'paciente')
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">⚡ Acciones Rápidas</div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <a href="{{ route('citas.create') }}" style="text-decoration: none; padding: 1.5rem; background: linear-gradient(135deg, rgba(0, 102, 204, 0.08), rgba(0, 212, 170, 0.08)); border: 2px solid var(--primary); border-radius: 10px; text-align: center; color: var(--primary); font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='linear-gradient(135deg, rgba(0, 102, 204, 0.15), rgba(0, 212, 170, 0.15))'" onmouseout="this.style.background='linear-gradient(135deg, rgba(0, 102, 204, 0.08), rgba(0, 212, 170, 0.95))'">
                        📅 Agendar Nueva Cita
                    </a>
                    <a href="{{ route('profile.edit') }}" style="text-decoration: none; padding: 1.5rem; background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(248, 188, 37, 0.84)); border: 2px solid var(--info); border-radius: 10px; text-align: center; color: var(--info); font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(99, 102, 241, 0.15))'" onmouseout="this.style.background='linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(99, 101, 241, 0.93))'">
                        👤 Actualizar Perfil
                    </a>
                    <a href="/" style="text-decoration: none; padding: 1.5rem; background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(43, 255, 121, 0.8)); border: 2px solid var(--success); border-radius: 10px; text-align: center; color: var(--success); font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(34, 197, 94, 0.15))'" onmouseout="this.style.background='linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(34, 197, 94, 0.95))'">
                        🏠 Ir al Inicio
                    </a>
                </div>
            </div>
            @endif
        </main>
    </div>
@endsection
