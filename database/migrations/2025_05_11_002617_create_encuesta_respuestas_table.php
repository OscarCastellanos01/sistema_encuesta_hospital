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
        Schema::create('encuesta_respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('codigoEncuestaRespuesta');
            $table->foreignId('idEncuesta')->references('id')->on('encuestas');
            $table->foreignId('idFacilitador')->references('id')->on('users');
            $table->foreignId('idEspecialidad')->references('id')->on('especialidad');
            $table->string('edadPaciente', 5);
            $table->tinyInteger('sexoPaciente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta_respuestas');
    }
};
