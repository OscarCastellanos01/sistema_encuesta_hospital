<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'El correo o la contraseña es incorrecto.');
        }

        $rol = Auth::user()->id_rol;

        if ($rol == 1) {
            return redirect()->route('encuesta.index');
        } elseif ($rol == 2) {
            return redirect()->route('encuesta.index');
        } elseif ($rol == 3) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->to('/');
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
