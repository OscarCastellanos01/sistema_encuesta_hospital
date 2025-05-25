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
        Schema::create('encuesta_preguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idEncuesta')->references('id')->on('encuestas');
            $table->string('tituloPregunta');
            $table->string('tipoPregunta')->default('nivel_satisfaccion'); // 'texto', 'numero', 'select', 'nivel_satisfaccion', 'hora', 'fecha', 'fecha_hora
            $table->tinyInteger('estadoPregunta')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta_preguntas');
    }
};
