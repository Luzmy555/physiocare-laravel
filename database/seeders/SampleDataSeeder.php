<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Fisioterapeuta;
use App\Models\Especialidad;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\CitaPublica;
use App\Models\HistorialClinico;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar médico de prueba
        $medicoEmail = 'medico@example.test';
        $fisioterapeuta = Fisioterapeuta::where('correo', $medicoEmail)->first();

        if (! $fisioterapeuta) {
            $this->command->error('No se encontró el fisioterapeuta de prueba: '.$medicoEmail);
            return;
        }

        // Asegurar especialidad
        $especialidad = Especialidad::firstOrCreate(['nombre' => 'Fisioterapia General'], ['descripcion' => 'Especialidad de fisioterapia general']);

        // Crear pacientes de ejemplo
        $pacientesData = [
            ['nombre' => 'Laura', 'apellido' => 'Gómez', 'correo' => 'laura@example.test', 'telefono' => '600111222', 'cedula' => 'V-12345678', 'fecha_nacimiento' => '1990-05-12'],
            ['nombre' => 'Carlos', 'apellido' => 'Pérez', 'correo' => 'carlos@example.test', 'telefono' => '600333444', 'cedula' => 'V-87654321', 'fecha_nacimiento' => '1985-10-02'],
            ['nombre' => 'María', 'apellido' => 'Rodríguez', 'correo' => 'maria@example.test', 'telefono' => '600555666', 'cedula' => 'V-11223344', 'fecha_nacimiento' => '1992-08-20'],
        ];

        $pacientes = [];
        foreach ($pacientesData as $p) {
            $pacientes[] = Paciente::updateOrCreate(
                ['correo' => $p['correo']],
                array_merge($p, ['direccion' => 'Av. Principal 123', 'sexo' => 'F'])
            );
        }

        // Crear citas internas (tabla 'citas') para los pacientes
        $dates = [Carbon::today(), Carbon::tomorrow(), Carbon::today()->addDays(3), Carbon::today()->subDays(7)];

        foreach ($pacientes as $i => $paciente) {
            $cita = Cita::create([
                'paciente_id' => $paciente->id,
                'fisioterapeuta_id' => $fisioterapeuta->id,
                'especialidad_id' => $especialidad->id,
                'fecha' => $dates[$i % count($dates)]->toDateString(),
                'hora' => sprintf('%02d:00', 9 + $i),
                'estado' => $i === 2 ? 'confirmada' : 'pendiente',
                'motivo' => 'Dolor lumbar y seguimiento',
            ]);

            // Crear historial clínico
            HistorialClinico::create([
                'paciente_id' => $paciente->id,
                'fisioterapeuta_id' => $fisioterapeuta->id,
                'cita_id' => $cita->id,
                'diagnostico' => 'Lumbalgia crónica',
                'tratamiento' => 'Ejercicios de fortalecimiento y terapia manual',
                'observaciones' => 'Buena evolución tras 3 sesiones',
                'fecha_registro' => $dates[$i % count($dates)]->toDateString(),
            ]);
        }

        // Crear citas públicas (para el listado del admin)
        CitaPublica::create([
            'cedula' => 'V-9990001',
            'nombres' => 'Paciente Publico',
            'apellidos' => 'Uno',
            'correo' => 'paciente1@example.test',
            'telefono' => '600777888',
            'especialidad_id' => $especialidad->id,
            'fisioterapeuta_id' => $fisioterapeuta->id,
            'fecha_cita' => Carbon::today()->addDay()->toDateString(),
            'hora_cita' => '10:30',
            'motivo' => 'Evaluación inicial',
            'estado' => 'pendiente',
        ]);

        CitaPublica::create([
            'cedula' => 'V-9990002',
            'nombres' => 'Paciente Publico',
            'apellidos' => 'Dos',
            'correo' => 'paciente2@example.test',
            'telefono' => '600111999',
            'especialidad_id' => $especialidad->id,
            'fisioterapeuta_id' => $fisioterapeuta->id,
            'fecha_cita' => Carbon::today()->addDays(5)->toDateString(),
            'hora_cita' => '14:00',
            'motivo' => 'Control de progreso',
            'estado' => 'confirmada',
        ]);

        $this->command->info('Seed de muestra: Pacientes, Citas e Historiales creados.');
    }
}
