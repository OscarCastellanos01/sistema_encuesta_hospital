<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    public function up()
    {
        Schema::create('area', function (Blueprint $table) {
            $table->id();
            $table->string('nombreArea', 100);
            $table->tinyInteger('estado')->default(1); // 1 for active, 0 for inactive
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('area');
    }
}
