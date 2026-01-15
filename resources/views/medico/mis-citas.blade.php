@extends('layouts.app', ['showNavbar' => false])

@section('content')
<style>
    .medico-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background: #f3f4f6;
        min-height: 100vh;
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

    .filters {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
        border: 1px solid #e5e7eb;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
    }

    .filter-input {
        padding: .5rem .75rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
    }

    .citas-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
        border: 1px solid #e5e7eb;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f3f4f6;
        padding: 1rem;
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        color: #1f2937;
    }

    tr:hover {
        background: #f9fafb;
    }

    .badge {
        padding: .25rem .75rem;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pendiente { background: #fef3c7; color: #d97706; }
    .badge-confirmada { background: #d1fae5; color: #059669; }
    .badge-completada { background: #dcfce7; color: #16a34a; }
    .badge-cancelada { background: #fee2e2; color: #dc2626; }

    .btn {
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-confirmar { background: #10b981; color: white; }
    .btn-cancelar { background: #ef4444; color: white; }

    .empty-state {
        text-align: center;
        padding: 3rem;
    }
</style>

<div class="medico-container">

    <div class="page-header">
        <div>
            <h1 class="page-title">📋 Mis Citas</h1>
            <p style="color:#6b7280;font-size:14px;">Gestión de tus citas médicas</p>
        </div>

        <a href="{{ route('dashboard') }}"
           style="background:#0066cc;color:white;padding:10px 18px;border-radius:8px;text-decoration:none;font-weight:600;">
            ← Volver
        </a>
    </div>

    <!-- FILTROS -->
    <div class="filters">
        <div class="filter-group">
            <label class="filter-label">Estado</label>
            <select class="filter-input" onchange="window.location='?estado='+this.value">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('estado')=='pendiente'?'selected':'' }}>Pendiente</option>
                <option value="confirmada" {{ request('estado')=='confirmada'?'selected':'' }}>Confirmada</option>
                <option value="completada" {{ request('estado')=='completada'?'selected':'' }}>Completada</option>
                <option value="cancelada" {{ request('estado')=='cancelada'?'selected':'' }}>Cancelada</option>
            </select>
        </div>
    </div>

    <!-- TABLA -->
    <div class="citas-table">
        @if($citas->count())
        <table>
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Especialidad</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($citas as $cita)
                <tr>
                    <td>
                        <strong>{{ $cita->nombres }} {{ $cita->apellidos }}</strong><br>
                        <small>{{ $cita->correo }}</small>
                    </td>

                    <td>{{ $cita->fecha_cita->format('d/m/Y') }}</td>
                    <td>{{ $cita->hora_cita }}</td>
                    <td>{{ $cita->especialidad->nombre }}</td>
                    <td>{{ Str::limit($cita->motivo, 40) }}</td>

                    <td>
                        <span class="badge badge-{{ strtolower($cita->estado) }}">
                            {{ ucfirst($cita->estado) }}
                        </span>
                    </td>

                    <td>
                        @if($cita->estado === 'pendiente')
                            <form action="{{ route('medico.confirmar-cita', $cita->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-confirmar">✔ Confirmar</button>
                            </form>

                            <form action="{{ route('admin.citas.cancelar', $cita->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-cancelar"
                                    onclick="return confirm('¿Cancelar esta cita?')">
                                    ✖ Cancelar
                                </button>
                            </form>
                        @else
                            <small style="color:#9ca3af;">Sin acciones</small>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $citas->links() }}

        @else
            <div class="empty-state">
                <h3>No tienes citas registradas</h3>
            </div>
        @endif
    </div>
</div>
@endsection
