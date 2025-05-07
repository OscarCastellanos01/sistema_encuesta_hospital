<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportacionReportesTable extends Migration
{
    public function up()
    {
        Schema::create('exportacion_reporte', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('tipoExportacion');
            $table->json('filtros');
            $table->unsignedBigInteger('idGeneradoPor');
            $table->timestamps();

            $table->foreign('idGeneradoPor')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exportacion_reporte');
    }
}
