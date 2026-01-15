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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            // Datos básicos del paciente
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('cedula')->nullable()->unique();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable()->unique();
            $table->date('fecha_nacimiento')->nullable();

            // Datos médicos generales
            $table->string('direccion')->nullable();
            $table->string('sexo')->nullable(); // F, M, Otro

            // Por si algún día agregas autenticación para pacientes
            $table->string('password')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
