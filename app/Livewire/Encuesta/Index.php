<?php

namespace App\Livewire\Encuesta;

use Livewire\Component;

class Index extends Component
{
    // Respuestas
    public array $answers = [
        'wait_time'   => null,
        'doctor_care' => null,
        'nurse_care'  => null,
        'cleanliness' => null,
    ];

    // Toggle “Acepto los términos”
    public bool $terms = false;

    protected $rules = [
        'answers.*' => 'required|integer|min:1|max:5',
        'terms'     => 'accepted',
    ];

    public function submit()
    {
        $this->validate();
        // guardar la encuesta
    }

    public function render()
    {
        return view('livewire.encuesta.index');
    }
}
