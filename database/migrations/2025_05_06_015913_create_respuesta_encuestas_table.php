<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestaEncuestasTable extends Migration
{
    public function up()
    {
        Schema::create('respuesta_encuesta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEncuesta');
            $table->unsignedBigInteger('idPregunta');
            $table->unsignedBigInteger('idNivelSatisfaccion');
            $table->timestamps();

            $table->foreign('idNivelSatisfaccion')->references('id')->on('nivel_satisfaccion');
            $table->foreign('idEncuesta')->references('id')->on('encuesta');
            $table->foreign('idPregunta')->references('id')->on('pregunta');
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuesta_encuestas');
    }
}
