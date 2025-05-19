<?php

namespace App\Livewire\user;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;

class Index extends Component
{
    public $userId;
    public $name, $email, $password, $estado_usuario = 1, $id_rol;

    public function mount($user = null)
    {
        if ($user) {
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->estado_usuario = $user->estado_usuario;
            $this->id_rol = $user->id_rol;
        }
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
            'estado_usuario' => 'required|in:0,1',
            'id_rol' => 'required|exists:rol,id',
        ]);

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        } else {
            unset($data['password']);
        }

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        session()->flash('success', $this->userId ? 'Usuario actualizado.' : 'Usuario creado.');

        $this->reset(['name', 'email', 'password', 'estado_usuario', 'id_rol', 'userId']);
    }

    public function render()
    {
        return view('livewire.user.index', [
            'usuarios' => User::with('rol')->get(), // o paginate si deseas
        ]);
    }
}
