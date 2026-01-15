<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Fisioterapeuta;
use App\Models\CitaPublica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CitasPublicasController extends Controller
{
    /**
     * Mostrar formulario de agendamiento público
     */
    public function create()
    {
        $especialidades = Especialidad::all();
        $fisioterapeutas = Fisioterapeuta::with('especialidad')->get();
        return view('citas.agendar-publico', compact('especialidades', 'fisioterapeutas'));
    }

    /**
     * Guardar nueva cita pública
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cedula' => 'required|string|max:20',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'especialidad_id' => 'required|exists:especialidades,id',
            'fisioterapeuta_id' => 'required|exists:fisioterapeutas,id',
            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:500',
        ], [
            'cedula.required' => 'La cédula es obligatoria',
            'nombres.required' => 'El nombre es obligatorio',
            'apellidos.required' => 'El apellido es obligatorio',
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'El correo debe ser válido',
            'telefono.required' => 'El teléfono es obligatorio',
            'especialidad_id.required' => 'Selecciona una especialidad',
            'fisioterapeuta_id.required' => 'Selecciona un fisioterapeuta',
            'fecha_cita.required' => 'La fecha es obligatoria',
            'fecha_cita.after_or_equal' => 'La fecha no puede ser en el pasado',
            'hora_cita.required' => 'La hora es obligatoria',
            'hora_cita.date_format' => 'El formato de hora debe ser HH:MM',
            'motivo.required' => 'Describe el motivo de tu cita',
        ]);

        try {
            // Crear cita pública
            $cita = CitaPublica::create(array_merge($validated, ['estado' => 'pendiente']));

            // Enviar correo de confirmación
            $this->enviarCorreoConfirmacion($cita);

            return redirect('/')->with('success', 'Cita agendada exitosamente. Revisa tu correo para la confirmación.');
        } catch (\Exception $e) {
            Log::error('Error al agendar cita: ' . $e->getMessage());
            return back()->with('error', 'Error al agendar la cita. Por favor intenta de nuevo.')->withInput();
        }
    }

    /**
     * Obtener fisioterapeutas de una especialidad (AJAX)
     */
    public function obtenerFisioterapeutas($especialidadId)
    {
        $hora = request('hora');
        $fisioterapeutas = Fisioterapeuta::where('especialidad_id', $especialidadId)
            ->when($hora, function ($query) use ($hora) {
                $query->where('horario_inicio', '<=', $hora)
                      ->where('horario_fin', '>=', $hora);
            })
            ->select('id', 'nombre', 'apellido', 'especialidad_id', 'horario_inicio', 'horario_fin')
            ->get();
        return response()->json($fisioterapeutas);
    }

    /**
     * Enviar correo de confirmación
     */
    private function enviarCorreoConfirmacion($cita)
    {
        $cita->load('especialidad', 'fisioterapeuta');

        $asunto = 'Confirmación de Cita - FisioCare Ayla';
        $fecha_formateada = date('d/m/Y', strtotime($cita->fecha_cita));

        $mensaje = "Estimado/a {$cita->nombres} {$cita->apellidos},\n\n";
        $mensaje .= "Su cita ha sido agendada exitosamente en FisioCare Ayla.\n\n";
        $mensaje .= "=== DETALLES DE LA CITA ===\n";
        $mensaje .= "Cédula: {$cita->cedula}\n";
        $mensaje .= "Teléfono: {$cita->telefono}\n";
        $mensaje .= "Correo: {$cita->correo}\n\n";
        $mensaje .= "Fisioterapeuta: {$cita->fisioterapeuta->nombre} {$cita->fisioterapeuta->apellido}\n";
        $mensaje .= "Especialidad: {$cita->especialidad->nombre}\n";
        $mensaje .= "Fecha: {$fecha_formateada}\n";
        $mensaje .= "Hora: {$cita->hora_cita}\n";
        $mensaje .= "Motivo: {$cita->motivo}\n\n";
        $mensaje .= "Estado: Pendiente de Confirmación\n\n";
        $mensaje .= "=== IMPORTANTE ===\n";
        $mensaje .= "- Por favor, llegar 10 minutos antes de la cita.\n";
        $mensaje .= "- Si necesitas cancelar o reprogramar, contacta a la clínica lo antes posible.\n\n";
        $mensaje .= "Teléfono de la clínica: +58 412-123-4567\n";
        $mensaje .= "Correo: info@fisiocarealya.com\n\n";
        $mensaje .= "¡Gracias por confiar en FisioCare Ayla!\n";
        $mensaje .= "Clínica de Fisioterapia\n";

        try {
            $headers = "From: noreply@fisiocarealya.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            mail($cita->correo, $asunto, $mensaje, $headers);
            Log::info('Correo de confirmación enviado a: ' . $cita->correo);
        } catch (\Exception $e) {
            Log::error('Error al enviar correo: ' . $e->getMessage());
        }
    }
}
