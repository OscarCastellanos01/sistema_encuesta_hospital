<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\EncuestaRespuesta;
use App\Models\EncuestaRespuestaDetalle;
use App\Models\RegistroFacilitador;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FacilitatorActivity extends Component
{
    public $timeRange = 'month';

    public function render()
    {
        $activity = $this->getFacilitatorActivity();
        $topFacilitators = $this->getTopFacilitators();

        return view('livewire.dashboard.facilitator-activity', [
            'activity' => $activity,
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

        // Convertimos a array plano
        return $query->get()->map(function ($item) {
            return [
                'date' => $item->date,
                'count' => $item->count,
            ];
        })->values()->toArray(); // <- MUY IMPORTANTE
    }


    protected function getTopFacilitators()
    {
        return EncuestaRespuesta::with(['facilitador', 'detalles.nivelSatisfaccion'])
            ->select(
                'idFacilitador',
                DB::raw('count(*) as response_count')
            )
            ->with(['facilitador' => function($query) {
                $query->select('id', 'name');
            }])
            ->groupBy('idFacilitador')
            ->orderByDesc('response_count')
            ->limit(5)
            ->get()
            ->map(function($item) {
                // Calcular promedio de satisfacción
                $satisfactionValues = $item->detalles
                    ->filter(fn($d) => $d->idNivelSatisfaccion !== null)
                    ->map(fn($d) => optional($d->nivelSatisfaccion)->valor ?? 0);
                
                $avgSatisfaction = $satisfactionValues->isNotEmpty() 
                    ? $satisfactionValues->avg() 
                    : 0;

                return (object)[
                    'facilitator_name' => $item->facilitador->name ?? 'Desconocido',
                    'response_count' => $item->response_count,
                    'avg_satisfaction' => (float)$avgSatisfaction
                ];
            });
    }
}