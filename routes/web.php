<?php

use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TipoCitaController;
use App\Http\Controllers\TipoEncuestaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\InformeExportPdfController;

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\FacilitadorAuth;
use App\Http\Middleware\SuperAuth;

// LOGIN como vista principal
Route::get('/', [SessionController::class, 'create'])->name('login');
Route::get('/login', [SessionController::class, 'create'])->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth')->name('login.destroy');

Route::middleware([FacilitadorAuth::class])->group(function () {

    // ==============================
    // MÓDULO ENCUESTAS
    // ==============================
    Route::get('/encuestas', [EncuestaController::class, 'index'])->name('encuesta.index');
    Route::get('/encuesta/{encuesta}/responder', [EncuestaController::class, 'response'])->name('encuesta.response');

});

Route::middleware([AdminAuth::class])->group(function () {

    // ==============================
    // MÓDULO ENCUESTAS
    // ==============================
    Route::get('/encuestas/crear', [EncuestaController::class, 'create'])->name('encuesta.create');
    Route::get('/encuesta/{encuesta}/editar', [EncuestaController::class, 'edit'])->name('encuesta.edit');
    Route::get('/encuesta/{encuesta}/respuestas', [EncuestaController::class, 'view'])->name('encuesta.view');

    // ==============================
    // Dashboard
    // ==============================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==============================
    // MÓDULO ÁREAS
    // ==============================
    Route::get('/area', fn() => view('area.index'))->name('area.index');

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
    // MÓDULO USUARIOS
    // ==============================
    Route::get('/usuarios', [UserController::class, 'index'])->name('user.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('user.create');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('user.edit');

    // ==============================
    // Informe PDF
    // ==============================
    Route::get('informes/encuestas/{encuesta}/pdf', [InformeExportPdfController::class, 'exportPdf'])->name('informes.encuestas.pdf');

});

Route::middleware([SuperAuth::class])->group(function () {

    // ==============================
    // MÓDULO NIVEL DE SATISFACCIÓN
    // ==============================
    Route::get('/nivel_satisfaccion', fn() => view('nivel_satisfaccion.index'))->name('nivel_satisfaccion.index');

    // ==============================
    // Bitacora
    // ==============================
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

});



