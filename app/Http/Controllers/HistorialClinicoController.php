<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Paciente;
use App\Models\Fisioterapeuta;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historiales = HistorialClinico::with('paciente', 'fisioterapeuta')->paginate(10);
        return view('historiales.index', compact('historiales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::all();
        $fisioterapeutas = Fisioterapeuta::all();
        return view('historiales.create', compact('pacientes', 'fisioterapeutas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fisioterapeuta_id' => 'required|exists:fisioterapeutas,id',
            'descripcion' => 'required|string',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string'
        ]);

        HistorialClinico::create($validated);
        return redirect()->route('historiales.index')->with('success', 'Historial clínico creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(HistorialClinico $historial)
    {
        $historial->load('paciente', 'fisioterapeuta');
        return view('historiales.show', compact('historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistorialClinico $historial)
    {
        $pacientes = Paciente::all();
        $fisioterapeutas = Fisioterapeuta::all();
        return view('historiales.edit', compact('historial', 'pacientes', 'fisioterapeutas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistorialClinico $historial)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fisioterapeuta_id' => 'required|exists:fisioterapeutas,id',
            'descripcion' => 'required|string',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string'
        ]);

        $historial->update($validated);
        return redirect()->route('historiales.show', $historial)->with('success', 'Historial clínico actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistorialClinico $historial)
    {
        $historial->delete();
        return redirect()->route('historiales.index')->with('success', 'Historial clínico eliminado exitosamente');
    }
}
