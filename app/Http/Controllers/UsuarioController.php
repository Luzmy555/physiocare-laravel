<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::with('rol')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        $usuario->load('rol');
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        $roles = Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'rol_id' => 'required|exists:roles,id',
        ]);
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }
        $usuario->update($validated);
        return redirect()->route('usuarios.show', $usuario)->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }

    /**
     * MÉTODOS PARA ADMINISTRADOR
     */

    /**
     * Listar usuarios para admin (usando el modelo User)
     */
    public function indexAdmin()
    {
        $usuarios = \App\Models\User::with('rol')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Crear nuevo usuario (admin)
     */
    public function createAdmin()
    {
        $roles = Rol::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Guardar nuevo usuario (admin)
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        \App\Models\User::create($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Editar usuario (admin)
     */
    public function editAdmin($id)
    {
        $usuario = \App\Models\User::findOrFail($id);
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario (admin)
     */
    public function updateAdmin(Request $request, $id)
    {
        $usuario = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'rol_id' => 'required|exists:roles,id',
        ]);

        // Si se proporciona contraseña, actualizarla
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $usuario->update($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Eliminar usuario (admin)
     */
    public function destroyAdmin($id)
    {
        $usuario = \App\Models\User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
