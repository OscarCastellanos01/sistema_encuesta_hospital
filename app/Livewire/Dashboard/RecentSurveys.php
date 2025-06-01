<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Encuesta;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RecentSurveys extends Component
{
    public $perPage = 5;
    public $selectedPeriod = 'month';
    public $currentPeriodText = '';

    public function mount()
    {
        $this->updateCurrentPeriodText();
    }

    public function updatedSelectedPeriod()
    {
        $this->updateCurrentPeriodText();
        $this->perPage = 5; // Resetear paginación al cambiar filtro
    }

    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function render()
    {
        $surveys = Encuesta::withCount(['respuestas'])
            ->when($this->selectedPeriod !== 'all', function($query) {
                $this->applyTimeFilter($query);
            })
            ->latest()
            ->take($this->perPage)
            ->get();

        return view('livewire.dashboard.recent-surveys', [
            'surveys' => $surveys,
            'hasMore' => $this->getTotalSurveysCount() > $this->perPage,
            'currentPeriodText' => $this->currentPeriodText,
            'periods' => [
                'today' => 'Hoy',
                'week' => 'Esta semana',
                'month' => 'Este mes',
                'last_month' => 'Mes anterior',
                'year' => 'Este año',
                'all' => 'Todos'
            ]
        ]);
    }

    protected function getTotalSurveysCount()
    {
        return Encuesta::query()
            ->when($this->selectedPeriod !== 'all', function($query) {
                $this->applyTimeFilter($query);
            })
            ->count();
    }

    protected function updateCurrentPeriodText()
    {
        $text = [
            'today' => 'Hoy (' . Carbon::today()->format('d/m/Y') . ')',
            'week' => 'Esta semana (' . 
                      Carbon::now()->startOfWeek()->format('d/m/Y') . ' - ' . 
                      Carbon::now()->endOfWeek()->format('d/m/Y') . ')',
            'month' => 'Este mes (' . Carbon::now()->format('F Y') . ')',
            'last_month' => 'Mes anterior (' . 
                           Carbon::now()->subMonthNoOverflow()->format('F Y') . ')',
            'year' => 'Este año (' . Carbon::now()->format('Y') . ')',
            'all' => 'Todos los registros'
        ][$this->selectedPeriod] ?? '';

        $this->currentPeriodText = $text;
    }

    protected function applyTimeFilter($query)
    {
        switch($this->selectedPeriod) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
                break;
            case 'last_month':
                $query->whereBetween('created_at', [
                    Carbon::now()->subMonthNoOverflow()->startOfMonth(),
                    Carbon::now()->subMonthNoOverflow()->endOfMonth()
                ]);
                break;
            case 'year':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ]);
                break;
        }
    }
}