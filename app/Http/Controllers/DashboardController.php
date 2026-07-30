<?php

namespace App\Http\Controllers;

use App\Models\CitaPublica;
use App\Models\Fisioterapeuta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard según el rol.
     */
    public function index()
    {
        $user = Auth::user();
        $rol = $user->rol ? $user->rol->nombre_rol : null;

        // Redirigir a vista específica según rol
        // Nota: el rol almacenado es 'medico' (ver RolesTableSeeder), no 'fisioterapeuta'.
        if ($rol === 'paciente') {
            return $this->dashboardPaciente($user);
        } elseif ($rol === 'medico') {
            return $this->dashboardFisioterapeuta($user);
        } elseif ($rol === 'admin') {
            return $this->dashboardAdmin($user);
        }

        return $this->dashboardDefault($user);
    }

    /**
     * Dashboard para Pacientes
     */
    private function dashboardPaciente($user)
    {
        $stats = [
            'citas_totales' => CitaPublica::where('correo', $user->email)->count(),
            'citas_proximas' => CitaPublica::where('correo', $user->email)
                ->where('fecha_cita', '>=', today())
                ->where('estado', '!=', 'cancelada')
                ->count(),
            'citas_completadas' => CitaPublica::where('correo', $user->email)
                ->where('estado', 'confirmada')
                ->count(),
            'citas_canceladas' => CitaPublica::where('correo', $user->email)
                ->where('estado', 'cancelada')
                ->count(),
        ];

        $rol = 'paciente';
        return view('dashboard', compact('stats', 'rol'));
    }

    /**
     * Dashboard para Fisioterapeutas
     */
    private function dashboardFisioterapeuta($user)
    {
        // Buscar si el usuario es fisioterapeuta
        $fisioterapeuta = Fisioterapeuta::where('user_id', $user->id)
    ->with('especialidad')
    ->first();
        if (!$fisioterapeuta) {
            abort(403, 'No tienes un perfil de fisioterapeuta');
        }

        $rol = 'fisioterapeuta';
        $citasHoy = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
            ->whereDate('fecha_cita', today())
            ->orderBy('hora_cita')
            ->get();

        $totalCitasHoy = $citasHoy->count();
        $proximaCita = $citasHoy->first();
        $proximaCitaHora = $proximaCita ? $proximaCita->hora_cita : '--';
        $proximaCitaPaciente = $proximaCita ? ($proximaCita->nombres . ' ' . $proximaCita->apellidos) : '--';

        $cantidadPendientes = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
            ->where('estado', 'pendiente')
            ->count();

        $totalPacientesMes = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
            ->whereMonth('fecha_cita', now()->month)
            ->distinct('correo')
            ->count('correo');

        $ultimaSesion = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
            ->orderByDesc('fecha_cita')
            ->orderByDesc('hora_cita')
            ->first();
        $ultimaSesion = $ultimaSesion ? $ultimaSesion->fecha_cita->format('d/m/Y') . ' ' . $ultimaSesion->hora_cita : 'Sin registros';

        $historialesRecientes = \App\Models\HistorialClinico::where('fisioterapeuta_id', $fisioterapeuta->id)
            ->with('paciente')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $notificaciones = [];
        if (class_exists('App\\Models\\Notificacion')) {
            $notificaciones = \App\Models\Notificacion::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact(
            'rol',
            'fisioterapeuta',
            'citasHoy',
            'totalCitasHoy',
            'proximaCitaHora',
            'proximaCitaPaciente',
            'cantidadPendientes',
            'totalPacientesMes',
            'historialesRecientes',
            'notificaciones',
            'ultimaSesion'
        ));
    }

    /**
     * Dashboard para Administrador
     */
    private function dashboardAdmin($user)
    {
        $stats = [
            'citas_totales' => CitaPublica::count(),
            'citas_hoy' => CitaPublica::whereDate('fecha_cita', today())->count(),
            'citas_pendientes' => CitaPublica::where('estado', 'pendiente')->count(),
            'citas_confirmadas' => CitaPublica::where('estado', 'confirmada')->count(),
            'pacientes_unicos' => CitaPublica::distinct('correo')->count('correo'),
            'fisioterapeutas_totales' => Fisioterapeuta::count(),
        ];

        $rol = 'admin';
        $citasRecientes = CitaPublica::with(['fisioterapeuta', 'especialidad'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'rol', 'citasRecientes'));
    }

    /**
     * Dashboard por defecto (sin rol asignado)
     */
    private function dashboardDefault($user)
    {
        $stats = [];
        $rol = 'default';
        return view('dashboard', compact('stats', 'rol'));
    }
}
