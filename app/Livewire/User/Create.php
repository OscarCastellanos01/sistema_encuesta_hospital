<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public $name;
    public $email;
    public $password;
    public $estado_usuario = 1;
    public $id_rol;
    public $roles;

    public function mount()
    {
        $this->roles = Role::where('estado', '<>', '1')->get();

    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'estado_usuario' => 'required|in:0,1',
            'id_rol' => 'required|exists:rol,id',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'estado_usuario' => $this->estado_usuario,
            'id_rol' => $this->id_rol,
        ]);

        session()->flash('success', 'Usuario creado correctamente.');

        $this->reset(['name', 'email', 'password', 'estado_usuario', 'id_rol']);
        $this->redirectRoute('user.index');
    }

    public function render()
    {
        return view('livewire.user.create', [
            'roles' => $this->roles,
        ]);
    }
}
