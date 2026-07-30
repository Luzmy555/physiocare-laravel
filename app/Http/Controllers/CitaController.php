<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Fisioterapeuta;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::with('paciente', 'fisioterapeuta')->paginate(10);
        return view('citas.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::all();
        $fisioterapeutas = Fisioterapeuta::all();
        $especialidades = Especialidad::all();
        return view('citas.create', compact('pacientes', 'fisioterapeutas', 'especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fisioterapeuta_id' => 'required|exists:fisioterapeutas,id',
            'especialidad_id' => 'required|exists:especialidades,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string',
            'estado' => 'required|in:pendiente,confirmada,cancelada'
        ]);

        Cita::create($validated);
        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        $cita->load('paciente', 'fisioterapeuta', 'especialidad');
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        $pacientes = Paciente::all();
        $fisioterapeutas = Fisioterapeuta::all();
        $especialidades = Especialidad::all();
        return view('citas.edit', compact('cita', 'pacientes', 'fisioterapeutas', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fisioterapeuta_id' => 'required|exists:fisioterapeutas,id',
            'especialidad_id' => 'required|exists:especialidades,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string',
            'estado' => 'required|in:pendiente,confirmada,cancelada'
        ]);

        $cita->update($validated);
        return redirect()->route('citas.show', $cita)->with('success', 'Cita actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente');
    }

    /**
     * MÉTODOS PARA ADMINISTRADOR
     */

    /**
     * Listar todas las citas (admin)
     */
    public function indexAdmin(Request $request)
    {
        $query = \App\Models\CitaPublica::with('fisioterapeuta', 'especialidad');

        // Filtrar por estado
        if ($request->has('estado') && $request->estado) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por fecha
        if ($request->has('fecha') && $request->fecha) {
            $query->whereDate('fecha_cita', $request->fecha);
        }

        $citas = $query->orderBy('fecha_cita', 'desc')->paginate(20);

        return view('admin.citas.index', compact('citas'));
    }

    /**
     * Confirmar cita (admin)
     */
    public function confirmarCitaAdmin($id)
    {
        $cita = \App\Models\CitaPublica::findOrFail($id);
        $cita->update(['estado' => 'confirmada']);

        return back()->with('success', 'Cita confirmada');
    }

    /**
     * Cancelar cita (admin)
     */
    public function cancelarCitaAdmin($id)
    {
        $cita = \App\Models\CitaPublica::findOrFail($id);
        $cita->update(['estado' => 'cancelada']);

        return back()->with('success', 'Cita cancelada');
    }
}
