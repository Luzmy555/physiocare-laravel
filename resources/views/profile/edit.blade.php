@extends('layouts.app', ['showNavbar' => false])
@section('content')
{{-- El estilo ahora se toma de public/assets/css/home.css igual que el dashboard --}}

    <div class="dashboard-wrapper">
        <!-- SIDEBAR -->
        <aside class="dashboard-sidebar">
            <div class="sidebar-profile">
                <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-role">
                    @if (Auth::user()->rol && Auth::user()->rol->nombre_rol === 'admin')
                        Administrador
                    @elseif (Auth::user()->rol && Auth::user()->rol->nombre_rol === 'fisioterapeuta')
                        Fisioterapeuta
                    @else
                        Paciente
                    @endif
                </div>
            </div>
            <ul class="sidebar-menu">
                @if (Auth::user()->rol && Auth::user()->rol->nombre_rol === 'admin')
                    <li><a href="{{ route('dashboard') }}">🏠 Panel</a></li>
                    <li><a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a></li>
                    <li><a href="{{ route('admin.medicos.index') }}">👨‍⚕️ Fisioterapeutas</a></li>
                    <li><a href="{{ route('admin.citas.index') }}">📋 Citas</a></li>
                    <li><a href="#">📊 Estadísticas</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="active">👤 Mi Perfil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Cerrar Sesión</a></li>
                @elseif (Auth::user()->rol && Auth::user()->rol->nombre_rol === 'fisioterapeuta')
                    <li><a href="{{ route('dashboard') }}">🏠 Inicio</a></li>
                    <li><a href="{{ route('medico.mis-citas') }}">📅 Mis Citas</a></li>
                    <li><a href="{{ route('medico.mis-pacientes') }}">📋 Historiales Clínicos</a></li>
                    <li><a href="#">🕒 Mi Horario</a></li>
                    <li><a href="#">🔔 Notificaciones</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="active">👤 Mi Perfil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Cerrar Sesión</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}">🏠 Inicio</a></li>
                    <li><a href="/agendar-cita">📅 Agendar Cita</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="active">👤 Mi Perfil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Cerrar Sesión</a></li>
                @endif
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title" style="font-size:40px; font-weight:900; color:#fff; margin-bottom:.25rem;">Mi Perfil</h1>
                <p class="page-subtitle" style="font-size:1.1rem; color:#0c457e; margin-bottom:0.5rem;">Gestiona tu información personal y de seguridad</p>
            </div>

            <!-- INFORMACION PERSONAL -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">📝 Información Personal</div>
                </div>
                @if (session('status') === 'profile-updated')
                    <div class="success-message">
                        ✓ Perfil actualizado correctamente
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" style="color:#111827; font-weight:700;">Nombre Completo</label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" style="color:#111827; font-weight:700;">Correo Electrónico</label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); color: #fff; font-weight:700; font-size:1rem; padding:0.75rem 1.5rem;">💾 Guardar Cambios</button>
                            <label for="password" style="color:#111827; font-weight:700;">Contraseña (para confirmar)</label>
                    </div>
                </form>
            </div>

            <!-- CAMBIAR CONTRASEÑA -->
            <div class="content-section">
                <div class="section-header">
                    <div class="section-title">🔐 Cambiar Contraseña</div>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group">
                            <label for="update_password_current_password" style="color:#111827; font-weight:700;">Contraseña Actual</label>
                            <input type="password" id="update_password_current_password" name="current_password" required>
                            @error('current_password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="update_password_password" style="color:#111827; font-weight:700;">Nueva Contraseña</label>
                            <input type="password" id="update_password_password" name="password" required>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="update_password_password_confirmation" style="color:#111827; font-weight:700;">Confirmar Contraseña</label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; font-weight:700; font-size:1rem; padding:0.75rem 1.5rem;">🔄 Actualizar Contraseña</button>
                    </div>
                </form>
            </div>

            <!-- ZONA DE PELIGRO -->
            <div class="content-section" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin-top:2rem;">
                <div style="background: #ffebee; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 1rem 1.5rem; text-align: center; border-bottom: 1px solid #e0e0e0;">
                    <span style="color: #d32f2f; font-size: 1.5rem; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <span style="color: #d32f2f; font-size: 2rem;">⚠️</span> Zona de Peligro
                    </span>
                </div>
                <div style="padding: 1.5rem;">
                    <p style="color: #424242; margin-bottom: 1.5rem; text-align:center; font-size:1.05rem;">
                        Una vez que elimines tu cuenta, no hay vuelta atrás.<br>Por favor, asegúrate de que realmente quieres eliminar tu cuenta.
                    </p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar permanentemente tu cuenta? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <div class="form-group" style="margin-bottom:1rem;">
                            <div style="display:flex; flex-direction:column; align-items:center;">
                                <label for="password" style="color:#d32f2f; font-weight:700; text-align:center; width:100%;">Contraseña (para confirmar)</label>
                                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required style="margin-top:0.5rem; text-align:center; width:80%; max-width:350px;">
                                @error('userDeletion.password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group" style="text-align:center;">
                            <button type="submit" class="btn-danger" style="background:#d32f2f; color:#fff; font-size:1rem; font-weight:700; padding:0.75rem 1.5rem; border:none; border-radius:6px;">🗑️ Eliminar Mi Cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
            </main>
        <main class="profile-content">

