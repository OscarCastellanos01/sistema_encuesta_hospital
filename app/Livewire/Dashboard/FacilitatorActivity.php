<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\EncuestaRespuesta;
use App\Models\RegistroFacilitador;
use Illuminate\Support\Facades\DB;

class FacilitatorActivity extends Component
{
    public $timeRange = 'month';
    
    protected $queryString = ['timeRange']; // Para mantener el estado en la URL
    
    public function updatedTimeRange($value)
    {
        // Este método se ejecutará automáticamente cuando cambie el valor
        $this->dispatch('refreshStats'); // Opcional: para notificar a otros componentes
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
            'timeRanges' => [
                'week' => 'Esta semana',
                'month' => 'Este mes',
                'quarter' => 'Este trimestre',
                'year' => 'Este año'
            ]
        ]);
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
                    'date' => \Carbon\Carbon::parse($item->date)->format('d M Y'), // Mejor formato de fecha
                    'count' => $item->count,
                    'raw_date' => $item->date // Mantenemos la fecha original para ordenamiento
                ];
            })
            ->sortBy('raw_date') // Ordenar por fecha
            ->values();
    }

    protected function applyTimeFilter($query)
    {
        switch($this->timeRange) {
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'quarter':
                $query->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()]);
                break;
            case 'year':
                $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
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