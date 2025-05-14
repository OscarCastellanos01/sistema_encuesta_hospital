<?php

use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/encuesta', [EncuestaController::class, 'index'])->name('encuesta.index');

Route::get('area', fn() => view('area.index'))->name('area.index');

Route::get('nivel_satisfaccion', fn() => view('nivel_satisfaccion.index'))
     ->name('nivel_satisfaccion.index');

Route::get('especialidad', fn() => view('especialidad.index'))
     ->name('especialidad.index');