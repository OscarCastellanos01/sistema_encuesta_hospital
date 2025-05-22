<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\tipo_encuesta;

class RecentSurveys extends Component
{
    public $perPage = 5;
    public $selectedType = 'all';

    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function render()
    {
        $surveys = Encuesta::with(['tipoEncuesta', 'respuestas'])
            ->when($this->selectedType !== 'all', function($query) {
                $query->where('idTipoEncuesta', $this->selectedType);
            })
            ->latest()
            ->take($this->perPage)
            ->get();

        return view('livewire.dashboard.recent-surveys', [
            'surveys' => $surveys,
            'types' => tipo_encuesta::all(),
            'hasMore' => Encuesta::count() > $this->perPage
        ]);
    }
}