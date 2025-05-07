<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroFacilitadorsTable extends Migration
{
    public function up()
    {
        Schema::create('registro_facilitador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idEncuesta');
            $table->timestamps();

            $table->foreign('idUsuario')->references('id')->on('users');
            $table->foreign('idEncuesta')->references('id')->on('encuesta');
        });
    }

    public function down()
    {
        Schema::dropIfExists('registro_facilitadors');
    }
}
