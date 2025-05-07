<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    public function up()
    {
        Schema::create('pregunta', function (Blueprint $table) {
            $table->id();
            $table->text('textoPregunta');
            $table->foreign('idencuesta')->references('id')->on('encuesta');
            $table->tinyInteger('estado')->default(1); // 1: Activo, 0: Inactivo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pregunta');
    }
}
