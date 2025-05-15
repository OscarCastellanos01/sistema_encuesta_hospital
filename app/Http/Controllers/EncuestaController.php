<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
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

    public function response(Encuesta $encuesta)
    {
        return view('encuesta.response', [
            'encuesta' => $encuesta
        ]);
    }

    public function edit(Encuesta $encuesta)
    {
        return view('encuesta.edit', [
            'encuesta' => $encuesta
        ]);
    }

    public function view(Encuesta $encuesta)
    {
        return view('encuesta.respuestas', [
            'encuesta' => $encuesta
        ]); 
    }
}
