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
        Schema::create('historiales_clinicos', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('fisioterapeuta_id')->nullable();
            $table->unsignedBigInteger('cita_id')->nullable();

            // Información clínica
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('observaciones')->nullable();

            // Fecha del registro
            $table->date('fecha_registro')->default(now());

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('fisioterapeuta_id')->references('id')->on('fisioterapeutas')->onDelete('set null');
            $table->foreign('cita_id')->references('id')->on('citas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiales_clinicos');
    }
};
