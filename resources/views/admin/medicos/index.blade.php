@extends('layouts.app')
@php($showNavbar = false)

@section('content')
<style>
    .admin-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        background: #f8fafc;
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

    .btn-primary {
        padding: 10px 20px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: #059669;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        border: 1px solid #e5e7eb;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background: #f3f4f6;
        padding: 1rem;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        color: #1f2937;
    }

    .table tbody tr:hover {
        background: #f9fafb;
    }

    .actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-small {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: all 0.2s;
    }

    .btn-edit {
        background: #3b82f6;
        color: white;
    }

    .btn-edit:hover {
        background: #2563eb;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background: #dc2626;
    }

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

    .spec-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border-radius: 20px;
            <div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2.5rem;">
        font-weight: 600;
                    <h1 class="page-title" style="font-size:2rem; font-weight:800; color:#0f172a; margin-bottom:.25rem;">👨‍⚕️ Gestión de Médicos</h1>
</style>

<div class="admin-container">
    <div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2.5rem;">
        <div>
            <h1 class="page-title" style="font-size:2rem; font-weight:800; color:#0f172a; margin-bottom:.25rem;">👨‍⚕️ Gestión de Fisioterapeutas</h1>
            <span style="color:#64748b; font-size:15px;">Total: <b>{{ $medicos->total() }}</b> fisioterapeutas</span>
        </div>
        <a href="{{ route('admin.medicos.create') }}" class="btn-primary" style="font-size:1rem; padding:12px 28px; border-radius:10px; background:#10b981; color:white; font-weight:700; box-shadow:0 1px 4px rgba(16,185,129,0.08);">
            ➕ Nuevo Fisioterapeuta
        </a>
    </div>

    <div class="table-container" style="background:white; border-radius:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); border:1px solid #e5e7eb;">
        @if ($medicos->count() > 0)
            <table class="table" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f3f4f6;">
                        <th style="padding:1rem; font-size:13px; color:#334155; font-weight:700;">Nombre</th>
                        <th style="padding:1rem; font-size:13px; color:#334155; font-weight:700;">Email</th>
                        <th style="padding:1rem; font-size:13px; color:#334155; font-weight:700;">Teléfono</th>
                        <th style="padding:1rem; font-size:13px; color:#334155; font-weight:700;">Especialidad</th>
                        <th style="padding:1rem; font-size:13px; color:#334155; font-weight:700;">Colegiado</th>
                        <th style="padding:1rem; font-size:13px; color:#334155; font-weight:700;">Acciones</th>
                    </tr>
                </thead>
                        </thead>
                        <th>Teléfono</th>
                        <th>Especialidad</th>
                        <th>Colegiatura</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicos as $medico)
                        <tr>
                            <td><strong>{{ $medico->nombre }} {{ $medico->apellido }}</strong></td>
                            <td>{{ $medico->correo }}</td>
                            <td>{{ $medico->telefono }}</td>
                            <td><span class="spec-badge">{{ $medico->especialidad->nombre }}</span></td>
                            <td style="padding:1rem; color:#334155; font-weight:600;">{{ $medico->numero_colegiado }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.medicos.edit', $medico->id) }}" class="btn-small btn-edit">✏️ Editar</a>
                                    <form action="{{ route('admin.medicos.destroy', $medico->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-small btn-delete">🗑️ Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($medicos instanceof \Illuminate\Pagination\Paginator)
                <div style="padding: 2rem; text-align: center;">
                    {{ $medicos->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">👨‍⚕️</div>
                <div class="empty-title">No hay médicos registrados</div>
            </div>
        @endif
    </div>

    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('dashboard') }}" style="padding: 10px 20px; background: #0066cc; color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
            ← Volver
        </a>
    </div>
</div>
@endsection
