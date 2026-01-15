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
        Schema::create('citas_publicas', function (Blueprint $table) {
            $table->id();
            $table->string('cedula')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo');
            $table->string('telefono');
            $table->unsignedBigInteger('especialidad_id');
            $table->unsignedBigInteger('fisioterapeuta_id');
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->text('motivo');
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('especialidad_id')->references('id')->on('especialidades')->onDelete('cascade');
            $table->foreign('fisioterapeuta_id')->references('id')->on('fisioterapeutas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas_publicas');
    }
};
