<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        /**
         * Run the migrations.
         */
        Schema::create('encuestas', function (Blueprint $table) {
            $table->id();
            $table->string('codigoEncuesta');
            $table->string('tituloEncuesta');
            $table->string('descripcionEncuesta')->nullable();
            $table->tinyInteger('estadoEncuesta')->default(1);
            $table->foreignId('idArea')->references('id')->on('area');
            $table->foreignId('idTipoEncuesta')->references('id')->on('tipo_encuesta');
            $table->foreignId('idTipoCita')->references('id')->on('tipo_cita');
            $table->foreignId('idUser')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuestas');
    }
};
