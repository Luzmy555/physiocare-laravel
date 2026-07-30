<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historial_clinico_id')->constrained('historiales_clinicos')->onDelete('cascade');
            $table->string('nombre_original');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('tamano');
            $table->string('subido_por')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_archivos');
    }
};
