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
        Schema::create('encuesta_opciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPregunta')->constrained('encuesta_preguntas');
            $table->string('valor');
            $table->string('etiqueta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta_opciones');
    }
};
