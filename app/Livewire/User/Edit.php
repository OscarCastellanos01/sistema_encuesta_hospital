<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $estado_usuario;
    public $id_rol;
    public $roles;

    public function mount(User $user)
    {
        $this->userId         = $user->id;
        $this->name           = $user->name;
        $this->email          = $user->email;
        $this->estado_usuario = $user->estado_usuario;
        $this->id_rol         = $user->id_rol;

        $this->roles = Role::where('estado', '<>', 1)->get();
    }

    public function save()
    {
        $this->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $this->userId,
            'password'       => 'nullable|min:6',
            'estado_usuario' => 'required|in:0,1',
            'id_rol'         => 'required|exists:rol,id',
        ]);

        $data = [
            'name'           => $this->name,
            'email'          => $this->email,
            'estado_usuario' => $this->estado_usuario,
            'id_rol'         => $this->id_rol,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        User::where('id', $this->userId)->update($data);

        session()->flash('success', 'Usuario actualizado correctamente.');

        return redirect()->route('user.index');
    }

    public function render()
    {
        return view('livewire.user.edit');
    }
}
