<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especialidades = Especialidad::withCount('fisioterapeutas')->paginate(10);
        return view('especialidades.index', compact('especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('especialidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|unique:especialidades',
            'descripcion' => 'required|string'
        ]);

        Especialidad::create($validated);
        return redirect()->route('especialidades.index')->with('success', 'Especialidad creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialidad $especialidad)
    {
        $especialidad->load('fisioterapeutas');
        return view('especialidades.show', compact('especialidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidad $especialidad)
    {
        return view('especialidades.edit', compact('especialidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Especialidad $especialidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|unique:especialidades,nombre,' . $especialidad->id,
            'descripcion' => 'required|string'
        ]);

        $especialidad->update($validated);
        return redirect()->route('especialidades.show', $especialidad)->with('success', 'Especialidad actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especialidad $especialidad)
    {
        $especialidad->delete();
        return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada exitosamente');
    }
}
