@extends('layouts.app', ['showNavbar' => false])

@section('content')
<style>
    .medico-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background: #f3f4f6;
        min-height: 100vh;
        margin-top: 0px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .citas-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
    }

    .citas-list {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .cita-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s;
    }

    .cita-card:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-color: #0066cc;
    }

    .cita-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .cita-hora {
        font-size: 24px;
        font-weight: 700;
        color: #0066cc;
    }

    .cita-estado {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .cita-estado.pendiente {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .cita-estado.confirmada {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .cita-estado.completada {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .cita-paciente {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .cita-info {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 0.75rem;
    }

    .cita-motivo {
        background: #f9fafb;
        padding: 0.75rem;
        border-radius: 8px;
        font-size: 13px;
        color: #4b5563;
        margin-bottom: 1rem;
    }

    .cita-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-small {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
    }

    .sidebar-stats {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .stat-box {
        text-align: center;
        padding: 1rem;
        background: linear-gradient(135deg, rgba(0, 102, 204, 0.08), rgba(0, 212, 170, 0.08));
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #0066cc;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        font-size: 14px;
        color: #6b7280;
    }
</style>

<div class="medico-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">🔥 Citas de Hoy</h1>
            <p style="color: #6b7280; font-size: 14px; margin-top: 0.5rem;">
                Pacientes programados para hoy
            </p>
        </div>
        <a href="{{ route('dashboard') }}" style="padding: 10px 20px; background: #0066cc; color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">← Volver</a>
    </div>

    <div class="citas-grid">
        <!-- CITAS LIST -->
        <div class="citas-list">
            @if ($citasHoy->count() > 0)
                @foreach ($citasHoy as $cita)
                    <div class="cita-card">
                        <div class="cita-header">
                            <div class="cita-hora">{{ $cita->hora_cita }}</div>
                            <span class="cita-estado {{ strtolower($cita->estado) }}">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </div>

                        <div class="cita-paciente">
                            {{ $cita->nombres }} {{ $cita->apellidos }}
                        </div>

                        <div class="cita-info">
                            📞 {{ $cita->telefono }}
                        </div>

                        <div class="cita-info">
                            📧 {{ $cita->correo }}
                        </div>

                        <div class="cita-info">
                            🏥 <strong>{{ $cita->especialidad->nombre }}</strong>
                        </div>

                        <div class="cita-motivo">
                            <strong>Motivo:</strong> {{ $cita->motivo }}
                        </div>

                        <div class="cita-actions">
                            @if ($cita->estado !== 'confirmada')
                                <form action="{{ route('medico.confirmar-cita', $cita->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-small btn-success">✓ Confirmar</button>
                                </form>
                            @endif
                            <button type="button" class="btn-small btn-warning" onclick="openNoteModal({{ $cita->id }}, '{{ $cita->nombres }}')">
                                📝 Nota
                            </button>
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

        <!-- SIDEBAR STATS -->
        <div class="sidebar-stats">
            <div class="stat-box">
                <div class="stat-number">{{ $citasHoy->count() }}</div>
                <div class="stat-label">Citas Hoy</div>
            </div>

            <div class="stat-box">
                <div class="stat-number">{{ $estadisticas['proximas'] ?? 0 }}</div>
                <div class="stat-label">Próximas</div>
            </div>

            <div class="stat-box">
                <div class="stat-number">{{ $estadisticas['pacientes_unicos'] ?? 0 }}</div>
                <div class="stat-label">Mis Pacientes</div>
            </div>

            <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid #e5e7eb;">

            <a href="{{ route('medico.mis-citas') }}" style="display: block; padding: 0.75rem; text-align: center; background: #0066cc; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; margin-bottom: 0.5rem;">
                📅 Todas Mis Citas
            </a>

            <a href="{{ route('medico.mis-pacientes') }}" style="display: block; padding: 0.75rem; text-align: center; background: #3b82f6; color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                👥 Mis Pacientes
            </a>
        </div>
    </div>
</div>

<!-- MODAL PARA AGREGAR NOTA -->
<div id="noteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%;">
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 1rem; color: #1f2937;">Agregar Nota - <span id="pacienteName"></span></h2>

        <form id="noteForm" method="POST">
            @csrf
            <textarea name="nota" placeholder="Escribe la nota clínica aquí..." style="width: 100%; height: 150px; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: vertical;" required></textarea>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeNoteModal()" style="flex: 1; padding: 0.75rem; background: #e5e7eb; color: #1f2937; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Cancelar
                </button>
                <button type="submit" style="flex: 1; padding: 0.75rem; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Guardar Nota
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openNoteModal(citaId, pacienteName) {
        document.getElementById('noteModal').style.display = 'flex';
        document.getElementById('pacienteName').textContent = pacienteName;
        document.getElementById('noteForm').action = '{{ route("medico.agregar-nota", ":id") }}'.replace(':id', citaId);
    }

    function closeNoteModal() {
        document.getElementById('noteModal').style.display = 'none';
        document.getElementById('noteForm').reset();
    }
</script>
@endsection
