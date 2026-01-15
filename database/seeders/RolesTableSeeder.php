<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre_rol' => 'paciente', 'descripcion' => 'Paciente (usuario registrado desde formulario público)'],
            ['nombre_rol' => 'medico', 'descripcion' => 'Médico o fisioterapeuta con cuenta asignada manualmente'],
            ['nombre_rol' => 'admin', 'descripcion' => 'Administrador del sistema con acceso al panel administrativo'],
        ];

        foreach ($roles as $r) {
            Rol::firstOrCreate(['nombre_rol' => $r['nombre_rol']], $r);
        }
    }
}
