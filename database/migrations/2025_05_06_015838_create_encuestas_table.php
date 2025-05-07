<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestasTable extends Migration
{
    public function up()
    {
        Schema::create('encuesta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_encuesta_id');
            $table->unsignedBigInteger('idFacilitador');
            $table->unsignedBigInteger('idArea');
            $table->integer('edadPaciente')->nullable();
            $table->tinyInteger('sexoPaciente')->nullable(); // 0: Masculino, 1: Femenino
            $table->unsignedBigInteger('idEspecialidad');
            $table->unsignedBigInteger('idTipoCita');
            $table->boolean('finalizada')->default(false);
            $table->timestamps();

            $table->foreign('tipo_encuesta_id')->references('id')->on('encuesta');
            $table->foreign('idFacilitador')->references('id')->on('users');
            $table->foreign('idArea')->references('id')->on('area');
            $table->foreign('idEspecialidad')->references('id')->on('especialidad');
            $table->foreign('idTipoCita')->references('id')->on('tipo_cita');
        });
    }

    public function down()
    {
        Schema::dropIfExists('encuesta');
    }
}

