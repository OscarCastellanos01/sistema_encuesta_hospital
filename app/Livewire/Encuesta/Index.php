<?php

namespace App\Livewire\Encuesta;

use App\Models\Encuesta;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class Index extends Component
{
    use WithoutUrlPagination, WithoutUrlPagination;

    public function render()
    {
        $encuestas = Encuesta::paginate(10);

        return view('livewire.encuesta.index', [
            'encuestas' => $encuestas
        ]);
    }
}
