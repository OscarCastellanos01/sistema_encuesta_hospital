<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_encuesta', function (Blueprint $table) {
            $table->id();
            $table->string('nombreTipoEncuesta', 100)->unique();
            $table->tinyInteger('estado')->default(1); // 1 for active, 0 for inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_encuesta');
    }
};
