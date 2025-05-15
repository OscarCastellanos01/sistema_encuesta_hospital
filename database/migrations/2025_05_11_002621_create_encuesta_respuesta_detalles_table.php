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
        Schema::create('encuesta_respuesta_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idEncuestaRespuesta')->references('id')->on('encuesta_respuestas');
            $table->foreignId('idPregunta')->references('id')->on('encuesta_preguntas');
            $table->foreignId('idNivelSatisfaccion')->references('id')->on('nivel_satisfaccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta_respuesta_detalles');
    }
};
