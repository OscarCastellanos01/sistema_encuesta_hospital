<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nivel_satisfaccion', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('codigoNivelSatisfaccion');
            $table->string('nombreNivelSatisfaccion', 100);
            $table->string('emojiSatisfaccion', 4);
            $table->string('porcentaje_nivel_satisfaccion', 5);
            $table->tinyInteger('estadoNivelSatisfaccion')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nivel_satisfaccion');
    }
};
