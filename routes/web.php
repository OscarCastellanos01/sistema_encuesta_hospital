<?php

use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\TipoEncuestaController;
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
// Route::get('/encuesta', [EncuestaController::class, 'index'])->name('encuesta.index');
Route::get('/encuestas', [EncuestaController::class, 'index'])->name('encuesta.index');
Route::get('/encuestas/crear', [EncuestaController::class, 'create'])->name('encuesta.create');
Route::get('/encuesta/{encuesta}/editar', [EncuestaController::class, 'edit'])->name('encuesta.edit');
Route::get('/encuesta/{encuesta}/respuestas', [EncuestaController::class, 'view'])->name('encuesta.view');
Route::get('/encuesta/{encuesta}/responder', [EncuestaController::class, 'response'])->name('encuesta.response');
Route::get('/tipo-encuesta', [TipoEncuestaController::class, 'index'])->name('tipoEncuesta.index');
