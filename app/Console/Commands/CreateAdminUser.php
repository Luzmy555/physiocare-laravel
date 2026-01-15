<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un usuario administrador de forma interactiva (solo para uso local)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Nombre completo');
        $email = $this->ask('Correo electrónico');
        $password = $this->secret('Contraseña');
        $rol_id = $this->ask('ID de rol para administrador (ej: 1)');

        if (User::where('email', $email)->exists()) {
            $this->error('Ya existe un usuario con ese correo.');
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'rol_id' => $rol_id,
        ]);

        $this->info('Usuario administrador creado correctamente: ' . $user->email);
        return 0;
    }
}
