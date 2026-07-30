<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\HistorialArchivo;
use App\Models\Paciente;
use App\Models\Fisioterapeuta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HistorialClinicoController extends Controller
{
    /**
     * Si el usuario autenticado es médico, devuelve el id de su propio
     * registro de Fisioterapeuta (para acotar consultas a "lo suyo").
     * Devuelve null para admin (sin acotar) o si no tiene perfil de médico.
     */
    private function fisioterapeutaIdDelMedicoActual(): ?int
    {
        $user = Auth::user();
        if (! $user->rol || $user->rol->nombre_rol !== 'medico') {
            return null;
        }

        return Fisioterapeuta::where('correo', $user->email)->value('id');
    }

    /**
     * Aborta con 403 si el historial no pertenece al médico autenticado
     * (los admin siempre pasan).
     */
    private function autorizarAccesoAlHistorial(HistorialClinico $historial): void
    {
        $miFisioterapeutaId = $this->fisioterapeutaIdDelMedicoActual();

        if ($miFisioterapeutaId !== null && $historial->fisioterapeuta_id !== $miFisioterapeutaId) {
            abort(403, 'No tienes acceso a este historial clínico.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = HistorialClinico::with('paciente', 'fisioterapeuta');

        if ($miFisioterapeutaId = $this->fisioterapeutaIdDelMedicoActual()) {
            $query->where('fisioterapeuta_id', $miFisioterapeutaId);
        }

        $historiales = $query->paginate(10);
        return view('historiales.index', compact('historiales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::all();
        $miFisioterapeutaId = $this->fisioterapeutaIdDelMedicoActual();

        // Un médico solo puede crear historiales a su propio nombre; un admin elige entre todos.
        $fisioterapeutas = $miFisioterapeutaId
            ? Fisioterapeuta::where('id', $miFisioterapeutaId)->get()
            : Fisioterapeuta::all();

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
            'observaciones' => 'required|string',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string'
        ]);

        // Un médico no puede atribuir el historial a otro fisioterapeuta,
        // sin importar lo que venga en el formulario.
        if ($miFisioterapeutaId = $this->fisioterapeutaIdDelMedicoActual()) {
            $validated['fisioterapeuta_id'] = $miFisioterapeutaId;
        }

        HistorialClinico::create($validated);
        return redirect()->route('historiales.index')->with('success', 'Historial clínico creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(HistorialClinico $historial)
    {
        $this->autorizarAccesoAlHistorial($historial);

        $historial->load('paciente', 'fisioterapeuta');
        return view('historiales.show', compact('historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistorialClinico $historial)
    {
        $this->autorizarAccesoAlHistorial($historial);

        $pacientes = Paciente::all();
        $miFisioterapeutaId = $this->fisioterapeutaIdDelMedicoActual();
        $fisioterapeutas = $miFisioterapeutaId
            ? Fisioterapeuta::where('id', $miFisioterapeutaId)->get()
            : Fisioterapeuta::all();

        return view('historiales.edit', compact('historial', 'pacientes', 'fisioterapeutas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistorialClinico $historial)
    {
        $this->autorizarAccesoAlHistorial($historial);

        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fisioterapeuta_id' => 'required|exists:fisioterapeutas,id',
            'observaciones' => 'required|string',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string'
        ]);

        if ($miFisioterapeutaId = $this->fisioterapeutaIdDelMedicoActual()) {
            $validated['fisioterapeuta_id'] = $miFisioterapeutaId;
        }

        $historial->update($validated);
        return redirect()->route('historiales.show', $historial)->with('success', 'Historial clínico actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistorialClinico $historial)
    {
        $this->autorizarAccesoAlHistorial($historial);

        $historial->delete();
        return redirect()->route('historiales.index')->with('success', 'Historial clínico eliminado exitosamente');
    }

    /**
     * Subir un archivo adjunto (nota, análisis, documento) al historial.
     */
    public function storeArchivo(Request $request, HistorialClinico $historial)
    {
        $this->autorizarAccesoAlHistorial($historial);

        $request->validate([
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $file = $request->file('archivo');
        $path = $file->store('historiales/' . $historial->id, 'local');

        $historial->archivos()->create([
            'nombre_original' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'tamano' => $file->getSize(),
            'subido_por' => Auth::user()->name ?? null,
        ]);

        return back()->with('success', 'Archivo adjuntado correctamente');
    }

    /**
     * Descargar un archivo adjunto.
     */
    public function downloadArchivo(HistorialArchivo $archivo)
    {
        $this->autorizarAccesoAlHistorial($archivo->historial);

        return Storage::disk('local')->download($archivo->path, $archivo->nombre_original);
    }

    /**
     * Eliminar un archivo adjunto.
     */
    public function destroyArchivo(HistorialArchivo $archivo)
    {
        $this->autorizarAccesoAlHistorial($archivo->historial);

        Storage::disk('local')->delete($archivo->path);
        $archivo->delete();

        return back()->with('success', 'Archivo eliminado correctamente');
    }
}
