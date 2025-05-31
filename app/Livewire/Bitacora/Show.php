<?php

namespace App\Http\Livewire\Bitacora;

use Livewire\Component;
use App\Models\Bitacora;

class Show extends Component
{
    public $bitacora; // Registro a mostrar
    public $bitacoraId; // ID recibido por URL

    // Montar el componente con el ID
    public function mount($id)
    {
        $this->bitacoraId = $id;
        $this->loadBitacora();
    }

    // Cargar el registro de la bitácora
    public function loadBitacora()
    {
        $this->bitacora = Bitacora::with('usuario')->findOrFail($this->bitacoraId);
    }

    public function render()
    {
        return view('livewire.bitacora.show', [
            'bitacora' => $this->bitacora
        ]);
    }
}
