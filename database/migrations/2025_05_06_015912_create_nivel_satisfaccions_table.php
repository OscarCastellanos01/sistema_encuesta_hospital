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
            $table->tinyInteger('nivelSatisfaccion');
            $table->string('emojiSatisfaccion', 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nivel_satisfaccion');
    }
};
