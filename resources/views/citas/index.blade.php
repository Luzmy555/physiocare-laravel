@extends('layouts.app')
@include('layouts.navbar_interno')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Citas</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('citas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Cita
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Fisioterapeuta</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($citas as $cita)
                <tr>
                    <td>{{ $cita->id }}</td>
                    <td>{{ $cita->paciente->usuario->nombre ?? 'N/A' }}</td>
                    <td>{{ $cita->fisioterapeuta->usuario->nombre ?? 'N/A' }}</td>
                    <td>{{ $cita->fecha_cita }}</td>
                    <td>{{ $cita->hora_cita }}</td>
                    <td>
                        @if ($cita->estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                        @elseif ($cita->estado == 'completada')
                            <span class="badge bg-success">Completada</span>
                        @else
                            <span class="badge bg-danger">Cancelada</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('citas.show', $cita->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" class="d-inline delete-cita-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-cancel-cita" data-cita-id="{{ $cita->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @section('scripts')
                    <div class="modal fade" id="modalCancelarCita" tabindex="-1" aria-labelledby="modalCancelarCitaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCancelarCitaLabel">Confirmar cancelación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas cancelar esta cita?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, volver</button>
                                    <button type="button" class="btn btn-danger" id="confirmCancelCita">Sí, cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                    let citaFormToDelete = null;
                    document.querySelectorAll('.btn-cancel-cita').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            citaFormToDelete = this.closest('form');
                            var modal = new bootstrap.Modal(document.getElementById('modalCancelarCita'));
                            modal.show();
                        });
                    });
                    document.getElementById('confirmCancelCita').addEventListener('click', function() {
                        if (citaFormToDelete) citaFormToDelete.submit();
                    });
                    </script>
                    @endsection
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay citas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $citas->links() }}
    </div>
</div>
@endsection
