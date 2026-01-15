<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Rol;
use App\Models\Especialidad;
use App\Models\Fisioterapeuta;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        $rolAdmin = Rol::firstOrCreate(['nombre_rol' => 'admin'], ['descripcion' => 'Administrador del sistema']);
        $rolMedico = Rol::firstOrCreate(['nombre_rol' => 'medico'], ['descripcion' => 'Médico / Fisioterapeuta']);

        // Credenciales de prueba
        $adminEmail = 'admin@example.test';
        $adminPassword = 'AdminPass123!';

        $medicoEmail = 'medico@example.test';
        $medicoPassword = 'MedicoPass123!';

        // Crear usuario admin
        $admin = User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin Demo',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'rol_id' => $rolAdmin->id,
            ]
        );

        // Crear usuario medico
        $medicoUser = User::updateOrCreate(
            ['email' => $medicoEmail],
            [
                'name' => 'Medico Demo',
                'email' => $medicoEmail,
                'password' => Hash::make($medicoPassword),
                'rol_id' => $rolMedico->id,
            ]
        );

        // Asegurar una especialidad para el médico
        $especialidad = Especialidad::firstOrCreate(
            ['nombre' => 'Fisioterapia General'],
            ['descripcion' => 'Especialidad de fisioterapia general']
        );

        // Crear registro de fisioterapeuta asociado al correo del médico (si no existe)
        $fisio = Fisioterapeuta::firstOrCreate(
            ['correo' => $medicoEmail],
            [
                'nombre' => 'Medico',
                'apellido' => 'Demo',
                'correo' => $medicoEmail,
                'telefono' => '600000000',
                'especialidad_id' => $especialidad->id,
                'numero_colegiado' => 'MD-TEST-001',
            ]
        );

        // Mostrar en consola (si se ejecuta por artisan db:seed)
        $this->command->info("Seeder de prueba: usuario admin => {$adminEmail} / {$adminPassword}");
        $this->command->info("Seeder de prueba: usuario medico => {$medicoEmail} / {$medicoPassword}");
    }
}
