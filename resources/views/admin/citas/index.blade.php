@php($showNavbar = false)
@extends('layouts.app')

@section('content')
<style>
    .admin-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        background: #f3f4f6;
        min-height: 100vh;
    }

    /* HEADER */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #011f4c;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-top: 0.25rem;
    }

    /* FILTROS */
    .filters {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .filters form {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 200px;
        flex: 1;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #00050e;
        text-transform: uppercase;
    }

    .filter-input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 15px;
        width: 100%;
    }

    .filter-btn {
        padding: 0.55rem 1.5rem;
        background: #011f4c;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        min-width: 180px;
    }

    .filter-btn:hover {
        background: #02306e;
    }

    /* TABLA */
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background: #f3f4f6;
        padding: 1rem;
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        color: #1f2937;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f9fafb;
    }

    .table th:nth-child(3),
    .table th:nth-child(4),
    .table th:nth-child(6),
    .table td:nth-child(3),
    .table td:nth-child(4),
    .table td:nth-child(6) {
        text-align: center;
    }

    /* BADGES */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pendiente { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .badge-confirmada { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .badge-completada { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
    .badge-cancelada { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    /* ACCIONES */
    .actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .btn-small {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 90px;
        border: none;
    }

    .btn-success { background: #10b981; color: white; }
    .btn-success:hover { background: #059669; }

    .btn-danger { background: #ef4444; color: white; }
    .btn-danger:hover { background: #dc2626; }

    /* PAGINACIÓN */
    .table-pagination {
        border-top: 1px solid #e5e7eb;
        padding: 1.5rem;
        background: #fff;
        text-align: center;
    }

    /* EMPTY */
    .empty-state {
        text-align: center;
        padding: 3rem;
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
</style>

<div class="admin-container">

    <!-- HEADER -->
    <div class="page-header">
        <h1 class="page-title">📋 Gestionar Citas</h1>
        <p class="page-subtitle">
            Total de citas registradas: <strong>{{ $citas->total() }}</strong>
        </p>
    </div>

    <!-- FILTROS -->
    <div class="filters">
        <form action="{{ route('admin.citas.index') }}" method="GET">
            <div class="filter-group">
                <label class="filter-label">Estado</label>
                <select name="estado" class="filter-input">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmada" {{ request('estado') === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="completada" {{ request('estado') === 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Fecha</label>
                <input type="date" name="fecha" class="filter-input" value="{{ request('fecha') }}">
            </div>

            <div class="filter-group">
                <button type="submit" class="filter-btn">🔍 Filtrar</button>
            </div>
        </form>
    </div>

    <!-- TABLA -->
    <div class="table-container">
        @if ($citas->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas as $cita)
                        <tr>
                            <td>
                                <strong>{{ $cita->nombres }} {{ $cita->apellidos }}</strong><br>
                                <small style="color:#6b7280;">{{ $cita->correo }}</small>
                            </td>
                            <td>{{ $cita->fisioterapeuta->nombre }} {{ $cita->fisioterapeuta->apellido }}</td>
                            <td>{{ $cita->fecha_cita->format('d/m/Y') }}</td>
                            <td>{{ $cita->hora_cita }}</td>
                            <td>{{ $cita->especialidad->nombre }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($cita->estado) }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    @if ($cita->estado !== 'confirmada')
                                        <form action="{{ route('admin.citas.confirmar', $cita->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-small btn-success">✓ Confirmar</button>
                                        </form>
                                    @endif

                                    @if ($cita->estado !== 'cancelada')
                                        <form action="{{ route('admin.citas.cancelar', $cita->id) }}" method="POST" onsubmit="return confirm('¿Cancelar esta cita?');">
                                            @csrf
                                            <button type="submit" class="btn-small btn-danger">✕ Cancelar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="table-pagination">
                {{ $citas->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <div class="empty-title">No hay citas</div>
            </div>
        @endif
    </div>

    <!-- VOLVER -->
    <div style="text-align:center; margin:3rem 0 1rem;">
        <a href="{{ route('dashboard') }}" class="btn-small" style="background:#0066cc; color:white; padding:0.75rem 2rem;">
            ← Volver al panel
        </a>
    </div>

</div>
@endsection
