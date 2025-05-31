<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index()
    {
        $bitacoras = Bitacora::with('usuario')->latest()->get();
        return view('bitacoras.index', compact('bitacoras')); // ← Nombre correcto
    }

    public function show(Bitacora $bitacora)
    {
        return view('bitacoras.show', compact('bitacora'));
    }
}