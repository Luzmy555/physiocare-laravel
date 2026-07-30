<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_publica_id')->constrained('citas_publicas')->onDelete('cascade');
            $table->foreignId('fisioterapeuta_id')->constrained('fisioterapeutas')->onDelete('cascade');
            $table->text('medicamentos');
            $table->text('indicaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
