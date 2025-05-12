<?php

use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\TipoEncuestaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/encuesta', [EncuestaController::class, 'index'])->name('encuesta.index');
Route::get('/encuestas', [EncuestaController::class, 'index'])->name('encuesta.index');
Route::get('/encuestas/crear', [EncuestaController::class, 'create'])->name('encuesta.create');
Route::get('/tipo-encuesta', [TipoEncuestaController::class, 'index'])->name('tipoEncuesta.index');