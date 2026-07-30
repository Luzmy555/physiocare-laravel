<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\FisioterapeutaController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CitasPublicasController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HorarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Rutas públicas para agendamiento de citas
Route::get('/agendar-cita', [CitasPublicasController::class, 'create'])->name('citas.publicas.create');
Route::post('/agendar-cita', [CitasPublicasController::class, 'store'])->name('citas.publicas.store');
Route::get('/api/fisioterapeutas/{especialidadId}', [CitasPublicasController::class, 'obtenerFisioterapeutas'])->name('api.fisioterapeutas');

Route::middleware('auth')->group(function () {
    // Solo admin gestiona el catálogo completo de pacientes/fisioterapeutas/especialidades/
    // citas internas/roles — el médico tiene sus propias vistas ya acotadas a lo suyo
    // (/medico/mis-citas, /medico/mis-pacientes) y el paciente ve lo suyo desde /dashboard.
    Route::middleware('role:admin')->group(function () {
        Route::resource('pacientes', PacienteController::class);
        Route::resource('fisioterapeutas', FisioterapeutaController::class);
        // ->parameters(): Laravel's English singularizer mangles these Spanish resource
        // names ("especialidades" -> "especialidade", "roles" -> "role"), which don't
        // match the controllers' typed parameter names ($especialidad, $rol) and
        // silently breaks implicit route-model binding (an empty model gets injected
        // instead of the real one).
        Route::resource('especialidades', EspecialidadController::class)->parameters(['especialidades' => 'especialidad']);
        Route::resource('citas', CitaController::class);
        Route::resource('roles', RolController::class)->parameters(['roles' => 'rol']);
    });

    // Historiales clínicos: admin ve todos; el médico solo los de sus propios pacientes
    // (el HistorialClinicoController filtra por su fisioterapeuta_id). El paciente no
    // tiene acceso — no hay una vista propia de "mi historial" todavía.
    Route::middleware('role:admin,medico')->group(function () {
        // ->parameters(): ver nota arriba — "historiales" -> "historiale" no coincide
        // con $historial en el controlador.
        Route::resource('historiales', HistorialClinicoController::class)->parameters(['historiales' => 'historial']);

        // Archivos adjuntos de un historial clínico
        Route::post('/historiales/{historial}/archivos', [HistorialClinicoController::class, 'storeArchivo'])->name('historiales.archivos.store');
        Route::get('/historiales/archivos/{archivo}/descargar', [HistorialClinicoController::class, 'downloadArchivo'])->name('historiales.archivos.download');
        Route::delete('/historiales/archivos/{archivo}', [HistorialClinicoController::class, 'destroyArchivo'])->name('historiales.archivos.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para Fisioterapeutas
    // El rol sembrado/almacenado es 'medico' (ver RolesTableSeeder), no 'fisioterapeuta';
    // con el nombre anterior este middleware nunca dejaba pasar a nadie (siempre 403).
Route::middleware('role:medico')->group(function () {

    Route::get('/medico/citas-hoy', [FisioterapeutaController::class, 'citasHoy'])
        ->name('medico.citas-hoy');

    Route::get('/medico/mis-citas', [FisioterapeutaController::class, 'misCitas'])
        ->name('medico.mis-citas');

    Route::get('/medico/mis-pacientes', [FisioterapeutaController::class, 'misPacientes'])
        ->name('medico.mis-pacientes');

    Route::get('/medico/mi-horario', [HorarioController::class, 'miHorario'])
        ->name('medico.mi-horario');

    Route::post('/medico/mi-horario/actualizar', [HorarioController::class, 'actualizarMiHorario'])
        ->name('medico.actualizar-mi-horario');

    Route::post('/medico/cita/{id}/confirmar', [FisioterapeutaController::class, 'confirmarCita'])
        ->name('medico.confirmar-cita');

    Route::post('/medico/cita/{id}/agregar-nota', [FisioterapeutaController::class, 'agregarNota'])
        ->name('medico.agregar-nota');

    Route::post('/medico/cita/{id}/receta', [FisioterapeutaController::class, 'guardarReceta'])
        ->name('medico.guardar-receta');

    Route::get('/medico/cita/{id}/receta', [FisioterapeutaController::class, 'verReceta'])
        ->name('medico.ver-receta');

});


    // Rutas para Administradores
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/usuarios', [UsuarioController::class, 'indexAdmin'])->name('admin.usuarios.index');
        Route::get('/admin/usuarios/crear', [UsuarioController::class, 'createAdmin'])->name('admin.usuarios.create');
        Route::post('/admin/usuarios', [UsuarioController::class, 'storeAdmin'])->name('admin.usuarios.store');
        Route::get('/admin/usuarios/{id}/editar', [UsuarioController::class, 'editAdmin'])->name('admin.usuarios.edit');
        Route::patch('/admin/usuarios/{id}', [UsuarioController::class, 'updateAdmin'])->name('admin.usuarios.update');
        Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroyAdmin'])->name('admin.usuarios.destroy');

        Route::get('/admin/medicos', [FisioterapeutaController::class, 'indexAdmin'])->name('admin.medicos.index');
        Route::get('/admin/medicos/crear', [FisioterapeutaController::class, 'createAdmin'])->name('admin.medicos.create');
        Route::post('/admin/medicos', [FisioterapeutaController::class, 'storeAdmin'])->name('admin.medicos.store');
        Route::get('/admin/medicos/{id}/editar', [FisioterapeutaController::class, 'editAdmin'])->name('admin.medicos.edit');
        Route::patch('/admin/medicos/{id}', [FisioterapeutaController::class, 'updateAdmin'])->name('admin.medicos.update');
        Route::delete('/admin/medicos/{id}', [FisioterapeutaController::class, 'destroyAdmin'])->name('admin.medicos.destroy');

        Route::get('/admin/especialidades', [EspecialidadController::class, 'indexAdmin'])->name('admin.especialidades.index');
        Route::get('/admin/especialidades/crear', [EspecialidadController::class, 'createAdmin'])->name('admin.especialidades.create');
        Route::post('/admin/especialidades', [EspecialidadController::class, 'storeAdmin'])->name('admin.especialidades.store');
        Route::get('/admin/especialidades/{id}/editar', [EspecialidadController::class, 'editAdmin'])->name('admin.especialidades.edit');
        Route::patch('/admin/especialidades/{id}', [EspecialidadController::class, 'updateAdmin'])->name('admin.especialidades.update');
        Route::delete('/admin/especialidades/{id}', [EspecialidadController::class, 'destroyAdmin'])->name('admin.especialidades.destroy');

        Route::get('/admin/citas', [CitaController::class, 'indexAdmin'])->name('admin.citas.index');
        Route::post('/admin/citas/{id}/confirmar', [CitaController::class, 'confirmarCitaAdmin'])->name('admin.citas.confirmar');
        Route::post('/admin/citas/{id}/cancelar', [CitaController::class, 'cancelarCitaAdmin'])->name('admin.citas.cancelar');
    });
});

require __DIR__.'/auth.php';
