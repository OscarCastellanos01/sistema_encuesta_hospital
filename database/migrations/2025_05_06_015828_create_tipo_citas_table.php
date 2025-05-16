<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoCitasTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_cita', function (Blueprint $table) {
            $table->id();
            $table->string('nombreTipoCita', 100);
            $table->tinyInteger('estadoTipoCita')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_cita');
    }
}
