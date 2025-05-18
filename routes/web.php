<?php

use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TipoCitaController;
use App\Http\Controllers\TipoEncuestaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// LOGIN como vista principal
Route::get('/', [SessionController::class, 'create'])->name('login');
Route::get('/login', [SessionController::class, 'create'])->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth')->name('login.destroy');

Route::middleware(['auth'])->group(function () {
    // ==============================
    // Dashboard
    // ==============================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==============================
    // MÓDULO ÁREAS
    // ==============================
    Route::get('/area', fn() => view('area.index'))->name('area.index');

    // ==============================
    // MÓDULO NIVEL DE SATISFACCIÓN
    // ==============================
    Route::get('/nivel_satisfaccion', fn() => view('nivel_satisfaccion.index'))->name('nivel_satisfaccion.index');

    // ==============================
    // MÓDULO ESPECIALIDAD
    // ==============================
    Route::get('/especialidad', fn() => view('especialidad.index'))->name('especialidad.index');

    // ==============================
    // MÓDULO TIPO DE ENCUESTA
    // ==============================
    Route::get('/tipo-encuesta', [TipoEncuestaController::class, 'index'])->name('tipoEncuesta.index');

    // ==============================
    // MÓDULO TIPO DE CITA
    // ==============================
    Route::get('/tipo-citas', [TipoCitaController::class, 'index'])->name('tipoCita.index');

    // ==============================
    // MÓDULO ENCUESTAS
    // ==============================
    Route::get('/encuestas', [EncuestaController::class, 'index'])->name('encuesta.index');
    Route::get('/encuestas/crear', [EncuestaController::class, 'create'])->name('encuesta.create');
    Route::get('/encuesta/{encuesta}/editar', [EncuestaController::class, 'edit'])->name('encuesta.edit');
    Route::get('/encuesta/{encuesta}/respuestas', [EncuestaController::class, 'view'])->name('encuesta.view');
    Route::get('/encuesta/{encuesta}/responder', [EncuestaController::class, 'response'])->name('encuesta.response');


    Route::get('/usuarios', [UserController::class, 'index'])->name('user.index');

});

