<?php

namespace App\Livewire\Encuesta;

use App\Models\Encuesta;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Respuestas extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $encuesta;
    public $search = '';
    public $expandedId;
    public $dateFrom;
    public $dateTo;

    public function mount(Encuesta $encuesta)
    {
        $this->encuesta = $encuesta;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function toggleExpand(int $id): void
    {
        $this->expandedId = ($this->expandedId === $id) ? null : $id;
    }

    public function render()
    {
        $query = $this->encuesta
            ->respuestas()
            ->with('detalles.pregunta','detalles.nivelSatisfaccion')
            // filtro de código
            ->when($this->search, fn($q) =>
                $q->where('codigoEncuestaRespuesta','like',"%{$this->search}%")
            )
            // filtro desde
            ->when($this->dateFrom, fn($q) =>
                $q->whereDate('created_at', '>=', $this->dateFrom)
            )
            // filtro hasta
            ->when($this->dateTo, fn($q) =>
                $q->whereDate('created_at', '<=', $this->dateTo)
            )
            ->orderBy('created_at','desc');

        $responses = $query->paginate(10);

        return view('livewire.encuesta.respuestas', [
            'responses' => $responses,
        ]);
    }
}
