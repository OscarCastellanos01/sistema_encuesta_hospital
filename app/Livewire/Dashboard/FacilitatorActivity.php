<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\EncuestaRespuesta;
use App\Models\RegistroFacilitador;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacilitatorActivity extends Component
{
    public $timeRange = 'month';
    public $currentPeriodText = '';
    
    protected $queryString = ['timeRange'];
    
    public function mount()
    {
        $this->updateCurrentPeriodText();
    }
    
    public function updatedTimeRange($value)
    {
        $this->updateCurrentPeriodText();
        $this->dispatch('refreshStats');
    }
    
    public function render()
    {
        $activity = $this->getFacilitatorActivity();
        $topFacilitators = $this->getTopFacilitators();
        
        $maxDailyCount = $activity->max('count') ?? 1;
        
        return view('livewire.dashboard.facilitator-activity', [
            'activity' => $activity,
            'maxDailyCount' => $maxDailyCount,
            'topFacilitators' => $topFacilitators,
            'currentPeriodText' => $this->currentPeriodText,
            'timeRanges' => [
                'today' => 'Hoy',
                'week' => 'Esta semana',
                'month' => 'Este mes',
                'last_month' => 'Mes anterior',
                'year' => 'Este año',
                'all' => 'Todos'
            ]
        ]);
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
        ][$this->timeRange] ?? '';

        $this->currentPeriodText = $text;
    }

    protected function getFacilitatorActivity()
    {
        $query = EncuestaRespuesta::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date');

        $this->applyTimeFilter($query);
        
        return $query->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d M Y'),
                    'count' => $item->count,
                    'raw_date' => $item->date
                ];
            })
            ->sortBy('raw_date')
            ->values();
    }

    protected function applyTimeFilter($query)
    {
        switch($this->timeRange) {
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

    protected function getTopFacilitators()
    {
        $query = EncuestaRespuesta::query()
            ->select(
                'idFacilitador',
                DB::raw('count(*) as response_count')
            )
            ->with(['facilitador' => function($query) {
                $query->select('id', 'name');
            }])
            ->groupBy('idFacilitador')
            ->orderByDesc('response_count')
            ->limit(5);

        $this->applyTimeFilter($query);
        
        return $query->get()
            ->map(function($item) {
                return (object)[
                    'facilitator_name' => $item->facilitador->name ?? 'Desconocido',
                    'response_count' => $item->response_count
                ];
            });
    }
}