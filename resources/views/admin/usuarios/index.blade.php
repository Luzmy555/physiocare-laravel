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

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-paciente {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .badge-medico {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-admin {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
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
</style>

<div class="admin-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">👥 Gestionar Usuarios</h1>
            <p style="color: #6b7280; font-size: 14px; margin-top: 0.5rem;">
                Total: {{ $usuarios->count() }} usuarios
            </p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="btn-primary">
            ➕ Nuevo Usuario
        </a>
    </div>

    <div class="table-container">
        @if ($usuarios->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Registrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>
                                <strong>{{ $usuario->name }}</strong>
                            </td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($usuario->rol->nombre_rol ?? 'paciente') }}">
                                    {{ ucfirst($usuario->rol->nombre_rol ?? 'Paciente') }}
                                </span>
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn-small btn-edit">
                                        ✏️ Editar
                                    </a>
                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro?');">
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
        @else
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <div class="empty-title">No hay usuarios</div>
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
