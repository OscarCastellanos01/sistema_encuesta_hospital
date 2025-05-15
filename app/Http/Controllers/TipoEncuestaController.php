<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipoEncuestaController extends Controller
{
    public function index()
    {
        return view('tipoEncuesta.index');
    }
}
