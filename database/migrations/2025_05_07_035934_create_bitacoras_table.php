<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacorasTable extends Migration
{
    public function up()
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idRegistro');
            $table->text('descripcion'); // Description of the action, format csv
            $table->tinyInteger('tipoAccion'); // 1 for insert, 2 for update, 3 for delete
            $table->unsignedBigInteger('idUsuario');
            $table->timestamps();

            $table->foreign('idUsuario')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
}
