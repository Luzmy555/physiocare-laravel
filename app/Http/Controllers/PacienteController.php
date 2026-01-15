<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::with('usuario')->paginate(10);
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = Usuario::all();
        return view('pacientes.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'sexo' => 'required|in:M,F'
        ]);

        Paciente::create($validated);
        return redirect()->route('pacientes.index')->with('success', 'Paciente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        $paciente->load('usuario', 'citas', 'historiales');
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paciente $paciente)
    {
        $usuarios = Usuario::all();
        return view('pacientes.edit', compact('paciente', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paciente $paciente)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'sexo' => 'required|in:M,F'
        ]);

        $paciente->update($validated);
        return redirect()->route('pacientes.show', $paciente)->with('success', 'Paciente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado exitosamente');
    }
}
