<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use App\Models\Fisioterapeuta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EspecialidadesYFisioterapeutasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear especialidades
        $especialidades = [
            ['nombre' => 'Traumatología', 'descripcion' => 'Tratamiento de lesiones óseas y articulares'],
            ['nombre' => 'Neurología', 'descripcion' => 'Rehabilitación del sistema nervioso'],
            ['nombre' => 'Cardiología', 'descripcion' => 'Rehabilitación cardiaca'],
            ['nombre' => 'Pediatría', 'descripcion' => 'Fisioterapia pediátrica'],
            ['nombre' => 'Geriatría', 'descripcion' => 'Atención a adultos mayores'],
            ['nombre' => 'Deportiva', 'descripcion' => 'Lesiones y recuperación deportiva'],
            ['nombre' => 'Respiratoria', 'descripcion' => 'Tratamiento de enfermedades respiratorias'],
            ['nombre' => 'Oncología', 'descripcion' => 'Rehabilitación post-cáncer'],
        ];

        $espec_ids = [];
        foreach ($especialidades as $esp) {
            $created = Especialidad::firstOrCreate(['nombre' => $esp['nombre']], $esp);
            $espec_ids[] = $created->id;
        }

        // Crear fisioterapeutas de prueba
        $fisioterapeutas = [
            [
                'nombre' => 'Carlos',
                'apellido' => 'Martínez',
                'telefono' => '+58 412-123-4567',
                'correo' => 'carlos@fisiocarealya.com',
                'especialidad_id' => $espec_ids[0],
                'numero_colegiado' => 'COL-2023-001',
                'password' => Hash::make('password'),
            ],
            [
                'nombre' => 'María',
                'apellido' => 'López',
                'telefono' => '+58 412-234-5678',
                'correo' => 'maria@fisiocarealya.com',
                'especialidad_id' => $espec_ids[1],
                'numero_colegiado' => 'COL-2023-002',
                'password' => Hash::make('password'),
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'García',
                'telefono' => '+58 412-345-6789',
                'correo' => 'juan@fisiocarealya.com',
                'especialidad_id' => $espec_ids[5],
                'numero_colegiado' => 'COL-2023-003',
                'password' => Hash::make('password'),
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Rodríguez',
                'telefono' => '+58 412-456-7890',
                'correo' => 'ana@fisiocarealya.com',
                'especialidad_id' => $espec_ids[3],
                'numero_colegiado' => 'COL-2023-004',
                'password' => Hash::make('password'),
            ],
            [
                'nombre' => 'Pedro',
                'apellido' => 'Fernández',
                'telefono' => '+58 412-567-8901',
                'correo' => 'pedro@fisiocarealya.com',
                'especialidad_id' => $espec_ids[2],
                'numero_colegiado' => 'COL-2023-005',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($fisioterapeutas as $fis) {
            Fisioterapeuta::firstOrCreate(['numero_colegiado' => $fis['numero_colegiado']], $fis);
        }

        $this->command->info('Especialidades y Fisioterapeutas creados exitosamente!');
    }
}
