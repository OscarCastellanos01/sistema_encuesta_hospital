<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipoCitaController extends Controller
{
    public function index()
    {
        return view('tipoCita.index');
    }
}
