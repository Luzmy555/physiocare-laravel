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

    .search-bar {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .search-bar input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
    }

    .pacientes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .paciente-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        transition: all 0.3s;
    }

    .paciente-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .paciente-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0066cc, #00d4aa);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .paciente-nombre {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .paciente-info {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .paciente-stats {
        display: flex;
        gap: 1rem;
        margin: 1rem 0;
        padding: 1rem 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    .stat-item {
        flex: 1;
        text-align: center;
    }

    .stat-number {
        font-size: 18px;
        font-weight: 700;
        color: #0066cc;
    }

    .stat-label {
        font-size: 11px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }

    .paciente-action {
        display: block;
        width: 100%;
        padding: 0.75rem;
        background: #0066cc;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }

    .paciente-action:hover {
        background: #0052a3;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .overview-card {
        background: linear-gradient(135deg, rgba(0, 102, 204, 0.08), rgba(0, 212, 170, 0.08));
        border: 2px solid rgba(0, 102, 204, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
    }

    .overview-number {
        font-size: 32px;
        font-weight: 700;
        color: #0066cc;
    }

    .overview-label {
        font-size: 13px;
        color: #6b7280;
        margin-top: 0.5rem;
        text-transform: uppercase;
    }
</style>

<div class="medico-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">👥 Mis Pacientes</h1>
            <p style="color: #6b7280; font-size: 14px; margin-top: 0.5rem;">
                Listado de pacientes que has atendido
            </p>
        </div>
        <a href="{{ route('dashboard') }}" style="padding: 10px 20px; background: #0066cc; color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">← Volver</a>
    </div>

    <!-- ESTADÍSTICAS GENERALES -->
    <div class="stats-overview">
        <div class="overview-card">
            <div class="overview-number">{{ $estadisticas['total_pacientes'] ?? 0 }}</div>
            <div class="overview-label">Pacientes Totales</div>
        </div>
        <div class="overview-card">
            <div class="overview-number">{{ $estadisticas['citas_completadas'] ?? 0 }}</div>
            <div class="overview-label">Citas Completadas</div>
        </div>
        <div class="overview-card">
            <div class="overview-number">{{ $estadisticas['citas_proximas'] ?? 0 }}</div>
            <div class="overview-label">Citas Próximas</div>
        </div>
    </div>

    <!-- BARRA DE BÚSQUEDA -->
    <div class="search-bar">
        <input type="text" id="searchPaciente" placeholder="🔍 Buscar por nombre, email o teléfono..."
               style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px;">
    </div>

    <!-- GRID DE PACIENTES -->
    @if ($pacientes->count() > 0)
        <div class="pacientes-grid">
            @foreach ($pacientes as $paciente)
                <div class="paciente-card">
                    <div class="paciente-avatar">
                        {{ strtoupper(substr($paciente['nombre'], 0, 1)) }}
                    </div>

                    <div class="paciente-nombre">{{ $paciente['nombre'] }} {{ $paciente['apellido'] }}</div>

                    <div class="paciente-info">
                        📧 {{ $paciente['correo'] }}
                    </div>

                    <div class="paciente-info">
                        📞 {{ $paciente['telefono'] }}
                    </div>

                    <div class="paciente-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $paciente['citas_totales'] }}</div>
                            <div class="stat-label">Citas</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $paciente['citas_completadas'] }}</div>
                            <div class="stat-label">Completadas</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $paciente['citas_proximas'] }}</div>
                            <div class="stat-label">Próximas</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        @if($paciente['historial_id'])
                            <a href="{{ route('historiales.show', $paciente['historial_id']) }}" class="paciente-action" style="flex:1; background:#0066cc;">
                                📋 Ver Historial
                            </a>
                            <a href="{{ route('historiales.edit', $paciente['historial_id']) }}" class="paciente-action" style="flex:1; background:#f59e0b;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('historiales.destroy', $paciente['historial_id']) }}" method="POST" style="flex:1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="paciente-action" style="background:#ef4444;" onclick="return confirm('¿Seguro que desea eliminar el historial?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        @else
                            <button class="paciente-action" style="flex:1; background:#d1d5db; color:#6b7280; cursor:not-allowed;" disabled>
                                📋 Sin historial
                            </button>
                            <button class="paciente-action" style="flex:1; background:#d1d5db; color:#6b7280; cursor:not-allowed;" disabled>
                                ✏️ Sin historial
                            </button>
                            <button class="paciente-action" style="flex:1; background:#d1d5db; color:#6b7280; cursor:not-allowed;" disabled>
                                🗑️ Sin historial
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <div class="empty-title">No tienes pacientes registrados</div>
            <p style="color: #6b7280; margin-top: 0.5rem;">Los pacientes aparecerán aquí cuando agenda citas contigo</p>
        </div>
    @endif
</div>

<script>
    document.getElementById('searchPaciente').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.paciente-card');

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
</script>
@endsection
