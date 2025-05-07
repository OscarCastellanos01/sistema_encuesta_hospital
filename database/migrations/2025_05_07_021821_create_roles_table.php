<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->id();
            $table->string('nombreRol', 25);
            $table->text('descripcion')->nullable();
            $table->tinyInteger('estado')->default(1); // 1 for active, 0 for inactive
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol');
    }
}
