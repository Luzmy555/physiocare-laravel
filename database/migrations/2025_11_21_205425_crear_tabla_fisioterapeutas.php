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
        Schema::create('fisioterapeutas', function (Blueprint $table) {
            $table->id();

            // Información personal
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable()->unique();

            // Datos profesionales
            $table->unsignedBigInteger('especialidad_id')->nullable(); // Relación con tabla especialidades
            $table->string('numero_colegiado')->nullable(); // Si tienen número profesional

            // Opcional (si algún día quieres login para ellos)
            $table->string('password')->nullable();

            $table->timestamps();

            // Llave foránea
            $table->foreign('especialidad_id')
                  ->references('id')
                  ->on('especialidades')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisioterapeutas');
    }
};
