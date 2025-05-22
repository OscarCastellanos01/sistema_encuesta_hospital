<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\EncuestaRespuestaDetalle;
use App\Models\nivel_satisfaccion;
use Illuminate\Support\Facades\DB;

class SatisfactionLevelChart extends Component
{
    public $selectedPeriod = 'month';

    protected $listeners = ['refreshChart' => '$refresh'];

    public function updatedSelectedPeriod()
    {
        $this->emit('refreshChart');
    }

    public function render()
    {
        $data = $this->prepareChartData();
        
        return view('livewire.dashboard.satisfaction-level-chart', [
            'chartData' => $data,
            'periods' => [
                'week' => 'Esta semana',
                'month' => 'Este mes',
                'year' => 'Este año',
                'all' => 'Todos'
            ]
        ]);
    }

    protected function prepareChartData()
    {
        $query = EncuestaRespuestaDetalle::query()
            ->whereNotNull('idNivelSatisfaccion')
            ->select('idNivelSatisfaccion', DB::raw('count(*) as total'))
            ->groupBy('idNivelSatisfaccion');
        
        // Aplicar filtro de periodo
        switch($this->selectedPeriod) {
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'year':
                $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
                break;
        }

        $results = $query->get();
        $levels = nivel_satisfaccion::orderBy('codigoNivelSatisfaccion')->get();

        // Mapear resultados a los niveles existentes
        $data = $levels->map(function($level) use ($results) {
            $found = $results->firstWhere('idNivelSatisfaccion', $level->id);
            return [
                'level' => $level,
                'count' => $found ? $found->total : 0
            ];
        });

        return [
            'labels' => $data->pluck('level.nombreNivelSatisfaccion'),
            'datasets' => [
                [
                    'label' => 'Niveles de Satisfacción',
                    'data' => $data->pluck('count'),
                    'backgroundColor' => $this->generateLevelColors($data->pluck('level')),
                    'borderWidth' => 1
                ]
            ],
            'emojis' => $data->pluck('level.emojiSatisfaccion')
        ];
    }

    protected function generateLevelColors($levels)
    {
        // Asigna colores según el código de nivel
        return $levels->map(function($level) {
            return match($level->codigoNivelSatisfaccion) {
                'NS1' => '#EF4444', // Rojo - Muy insatisfecho
                'NS2' => '#F59E0B', // Amarillo - Insatisfecho
                'NS3' => '#84CC16', // Verde claro - Neutral
                'NS4' => '#10B981', // Verde - Satisfecho
                'NS5' => '#3B82F6',  // Azul - Muy satisfecho
                default => '#94A3B8' // Gris - Default
            };
        })->toArray();
    }
}