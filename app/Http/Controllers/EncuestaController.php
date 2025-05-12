<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncuestaController extends Controller
{
    public function index()
    {
        return view('encuesta.index');
    }

    public function create()
    {
        return view('encuesta.create');
    }
}
