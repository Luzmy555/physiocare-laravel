<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Rol::withCount('usuarios')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_rol' => 'required|string|unique:roles',
            'descripcion' => 'required|string'
        ]);

        Rol::create($validated);
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rol $rol)
    {
        $rol->load('usuarios');
        return view('roles.show', compact('rol'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $rol)
    {
        return view('roles.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rol $rol)
    {
        $validated = $request->validate([
            'nombre_rol' => 'required|string|unique:roles,nombre_rol,' . $rol->id,
            'descripcion' => 'required|string'
        ]);

        $rol->update($validated);
        return redirect()->route('roles.show', $rol)->with('success', 'Rol actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}
