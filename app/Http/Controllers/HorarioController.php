<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;

class HorarioController extends Controller
{
   public function miHorario()
{
    $user = auth()->user();

    if (!$user->fisioterapeuta) {
        abort(403, 'No tienes un perfil de fisioterapeuta');
    }

    $horarios = Horario::where('fisioterapeuta_id', $user->fisioterapeuta->id)
        ->orderByRaw("FIELD(dia, 'lunes','martes','miercoles','jueves','viernes','sabado','domingo')")
        ->get();

    // Agrupamos por día, asegurando que todas las claves existan
    $dias = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
    $horariosPorDia = [];
    foreach ($dias as $dia) {
        $horariosPorDia[$dia] = $horarios->where('dia', $dia)->values(); // values() para que sea Collection indexable
    }

    return view('fisioterapeutas.horario', compact('horariosPorDia'));
}


    public function actualizarMiHorario(Request $request)
    {
        $user = auth()->user();

        if (!$user->fisioterapeuta) {
            abort(403);
        }

        $fisioId = $user->fisioterapeuta->id;

        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

        foreach ($dias as $dia) {
            $disponible = $request->has($dia . '_disponible');
            $hora_inicio = $request->input($dia . '_hora_inicio');
            $hora_fin = $request->input($dia . '_hora_fin');

            Horario::updateOrCreate(
                [
                    'fisioterapeuta_id' => $fisioId,
                    'dia' => $dia,
                ],
                [
                    'disponible' => $disponible,
                    'hora_inicio' => $disponible ? $hora_inicio : null,
                    'hora_fin' => $disponible ? $hora_fin : null,
                ]
            );
        }

        return redirect()
            ->route('medico.mi-horario')
            ->with('success', 'Horario actualizado correctamente.');
    }
}
