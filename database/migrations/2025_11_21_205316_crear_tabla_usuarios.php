<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();

            // Información personal
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('email')->unique();
            $table->string('password');

            // Teléfono opcional
            $table->string('telefono')->nullable();

            // Validación de correo (opcional)
            $table->timestamp('email_verified_at')->nullable();

            // Relación con rol
            $table->foreignId('rol_id')
                  ->constrained('roles')
                  ->onDelete('cascade');

            // Token para mantener sesión
            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
