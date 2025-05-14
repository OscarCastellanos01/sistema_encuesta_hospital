<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialidadTable extends Migration
{
    public function up()
    {
        Schema::create('especialidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEspecialidad', 100);
            $table->tinyInteger('estadoEspecialidad')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('especialidad');
    }
}

