<?php

use App\Http\Controllers\EncuestaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/encuesta', [EncuestaController::class, 'index'])->name('encuesta.index');