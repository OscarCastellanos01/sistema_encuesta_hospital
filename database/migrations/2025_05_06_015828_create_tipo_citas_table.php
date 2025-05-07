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
            $table->string('tipoCita', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_cita');
    }
}
