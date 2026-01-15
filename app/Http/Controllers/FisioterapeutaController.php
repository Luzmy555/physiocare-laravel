<?php

namespace App\Http\Controllers;

use App\Models\Fisioterapeuta;
use App\Models\Usuario;
use App\Models\Especialidad;
use App\Models\CitaPublica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FisioterapeutaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fisioterapeutas = Fisioterapeuta::with('usuario', 'especialidad')->paginate(10);
        return view('fisioterapeutas.index', compact('fisioterapeutas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = Usuario::all();
        $especialidades = Especialidad::all();
        return view('fisioterapeutas.create', compact('usuarios', 'especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'especialidad_id' => 'required|exists:especialidades,id',
            'numero_colegiatura' => 'required|string|unique:fisioterapeutas',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fin' => 'required|date_format:H:i|after:horario_inicio',
        ]);

        Fisioterapeuta::create($validated);
        return redirect()->route('fisioterapeutas.index')->with('success', 'Fisioterapeuta creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fisioterapeuta $fisioterapeuta)
    {
        $fisioterapeuta->load('usuario', 'especialidad', 'citas');
        return view('fisioterapeutas.show', compact('fisioterapeuta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fisioterapeuta $fisioterapeuta)
    {
        $usuarios = Usuario::all();
        $especialidades = Especialidad::all();
        return view('fisioterapeutas.edit', compact('fisioterapeuta', 'usuarios', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fisioterapeuta $fisioterapeuta)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'especialidad_id' => 'required|exists:especialidades,id',
            'numero_colegiatura' => 'required|string|unique:fisioterapeutas,numero_colegiatura,' . $fisioterapeuta->id,
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fin' => 'required|date_format:H:i|after:horario_inicio',
        ]);

        $fisioterapeuta->update($validated);
        return redirect()->route('fisioterapeutas.show', $fisioterapeuta)->with('success', 'Fisioterapeuta actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fisioterapeuta $fisioterapeuta)
    {
        $fisioterapeuta->delete();
        return redirect()->route('fisioterapeutas.index')->with('success', 'Fisioterapeuta eliminado exitosamente');
    }

    /**
     * MÉTODOS PARA MÉDICOS
     */

    /**
     * Mostrar citas de hoy del médico
     */
    public function citasHoy()
    {
        $user = Auth::user();
        $fisioterapeuta = Fisioterapeuta::where('correo', $user->email)->first();

        if (!$fisioterapeuta) {
            return redirect('/dashboard')->with('error', 'Perfil de médico no encontrado');
        }

        $citasHoy = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
            ->whereDate('fecha_cita', today())
            ->orderBy('hora_cita')
            ->get();

        $estadisticas = [
            'proximas' => CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->where('fecha_cita', '>', today())
                ->count(),
            'pacientes_unicos' => CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->distinct('correo')
                ->count('correo'),
        ];

        return view('medico.citas-hoy', compact('citasHoy', 'estadisticas'));
    }

    /**
     * Mostrar todas las citas del médico
     */
    public function misCitas(Request $request)
    {
        $user = Auth::user();
        $fisioterapeuta = Fisioterapeuta::where('correo', $user->email)->first();

        if (!$fisioterapeuta) {
            return redirect('/dashboard')->with('error', 'Perfil de médico no encontrado');
        }

        $query = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id);

        // Filtrar por estado si se proporciona
        if ($request->has('estado') && $request->estado) {
            $query->where('estado', $request->estado);
        }

        // Ordenar
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'fecha-asc':
                    $query->orderBy('fecha_cita', 'asc');
                    break;
                case 'hora':
                    $query->orderBy('hora_cita');
                    break;
                default:
                    $query->orderBy('fecha_cita', 'desc');
            }
        } else {
            $query->orderBy('fecha_cita', 'desc');
        }

        $citas = $query->paginate(15);

        return view('medico.mis-citas', compact('citas'));
    }

    /**
     * Mostrar mis pacientes
     */
    public function misPacientes()
    {
        $user = Auth::user();
        $fisioterapeuta = Fisioterapeuta::where('correo', $user->email)->first();

        if (!$fisioterapeuta) {
            return redirect('/dashboard')->with('error', 'Perfil de médico no encontrado');
        }


        // Obtener pacientes únicos
        $citasPacientes = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
            ->selectRaw('DISTINCT correo, nombres, apellidos, telefono')
            ->get();

        $pacientes = $citasPacientes->map(function($cita) use ($fisioterapeuta) {
            $totalCitas = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->where('correo', $cita->correo)
                ->count();

            $citasCompletadas = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->where('correo', $cita->correo)
                ->where('estado', 'confirmada')
                ->count();

            $citasProximas = CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->where('correo', $cita->correo)
                ->where('fecha_cita', '>=', today())
                ->where('estado', '!=', 'cancelada')
                ->count();

            // Buscar el modelo Paciente por correo
            $pacienteModel = \App\Models\Paciente::where('correo', $cita->correo)->first();
            // Buscar el historial clínico más reciente de ese paciente (si existe)
            $historial = $pacienteModel ? $pacienteModel->historiales()->latest()->first() : null;

            return [
                'nombre' => $cita->nombres,
                'apellido' => $cita->apellidos,
                'correo' => $cita->correo,
                'telefono' => $cita->telefono,
                'citas_totales' => $totalCitas,
                'citas_completadas' => $citasCompletadas,
                'citas_proximas' => $citasProximas,
                'historial_id' => $historial ? $historial->id : null,
            ];
        })->values();

        $estadisticas = [
            'total_pacientes' => $pacientes->count(),
            'citas_completadas' => CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->where('estado', 'confirmada')
                ->count(),
            'citas_proximas' => CitaPublica::where('fisioterapeuta_id', $fisioterapeuta->id)
                ->where('fecha_cita', '>=', today())
                ->count(),
        ];

        return view('medico.mis-pacientes', compact('pacientes', 'estadisticas'));
    }

    /**
     * Confirmar una cita
     */
    public function confirmarCita($id)
    {
        $cita = CitaPublica::findOrFail($id);
        $cita->update(['estado' => 'confirmada']);

        return back()->with('success', 'Cita confirmada correctamente');
    }

    /**
     * Agregar nota a una cita
     */
    public function agregarNota(Request $request, $id)
    {
        $cita = CitaPublica::findOrFail($id);
        $validated = $request->validate([
            'nota' => 'required|string|min:10',
        ]);

        $cita->update([
            'notas_medico' => $validated['nota'],
        ]);

        return back()->with('success', 'Nota agregada correctamente');
    }

    /**
     * MÉTODOS PARA ADMINISTRADOR
     */

    /**
     * Listar médicos para admin
     */
    public function indexAdmin()
    {
        $medicos = Fisioterapeuta::with('especialidad')->paginate(10);
        return view('admin.medicos.index', compact('medicos'));
    }

    /**
     * Crear nuevo médico (admin)
     */
    public function createAdmin()
    {
        $especialidades = Especialidad::all();
        return view('admin.medicos.create', compact('especialidades'));
    }

    /**
     * Guardar nuevo médico (admin)
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:fisioterapeutas',
            'telefono' => 'required|string|max:20',
            'especialidad_id' => 'required|exists:especialidades,id',
            'numero_colegiado' => 'required|string|unique:fisioterapeutas',
        ]);

        Fisioterapeuta::create($validated);

        return redirect()->route('admin.medicos.index')->with('success', 'Médico creado exitosamente');
    }

    /**
     * Editar médico (admin)
     */
    public function editAdmin($id)
    {
        $medico = Fisioterapeuta::findOrFail($id);
        $especialidades = Especialidad::all();
        return view('admin.medicos.edit', compact('medico', 'especialidades'));
    }

    /**
     * Actualizar médico (admin)
     */
    public function updateAdmin(Request $request, $id)
    {
        $medico = Fisioterapeuta::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:fisioterapeutas,correo,' . $id,
            'telefono' => 'required|string|max:20',
            'especialidad_id' => 'required|exists:especialidades,id',
            'numero_colegiado' => 'required|string|unique:fisioterapeutas,numero_colegiado,' . $id,
        ]);

        $medico->update($validated);

        return redirect()->route('admin.medicos.index')->with('success', 'Médico actualizado exitosamente');
    }

    /**
     * Eliminar médico (admin)
     */
    public function destroyAdmin($id)
    {
        $medico = Fisioterapeuta::findOrFail($id);
        $medico->delete();

        return redirect()->route('admin.medicos.index')->with('success', 'Médico eliminado exitosamente');
    }
}
