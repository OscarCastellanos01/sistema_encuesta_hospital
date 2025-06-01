<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\nivel_satisfaccion;
use App\Models\EncuestaRespuestaDetalle;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SatisfactionLevelChart extends Component
{
    public $selectedPeriod = 'month';
    public $currentPeriodText = '';

    protected $listeners = ['refreshChart' => '$refresh'];

    public function mount()
    {
        $this->updateCurrentPeriodText();
    }

    public function updatedSelectedPeriod()
    {
        $this->updateCurrentPeriodText();
    }

    public function render()
    {
        $satisfactionLevels = $this->getSatisfactionLevelsWithStats();
        
        return view('livewire.dashboard.satisfaction-level-chart', [
            'satisfactionLevels' => $satisfactionLevels,
            'totalResponses' => $satisfactionLevels->sum('count'),
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

    protected function getSatisfactionLevelsWithStats()
    {
        $counts = EncuestaRespuestaDetalle::query()
            ->select(
                'idNivelSatisfaccion',
                DB::raw('count(*) as respuestas_count')
            )
            ->whereNotNull('idNivelSatisfaccion')
            ->when($this->selectedPeriod !== 'all', function($query) {
                $query->whereHas('encuestaRespuesta', function($q) {
                    $this->applyTimeFilter($q);
                });
            })
            ->groupBy('idNivelSatisfaccion')
            ->pluck('respuestas_count', 'idNivelSatisfaccion');

        return nivel_satisfaccion::query()
            ->where('estadoNivelSatisfaccion', 1)
            ->orderBy('codigoNivelSatisfaccion')
            ->get()
            ->map(function($level) use ($counts) {
                return (object) [
                    'id' => $level->id,
                    'codigo' => $level->codigoNivelSatisfaccion,
                    'nombre' => $level->nombreNivelSatisfaccion,
                    'emoji' => $level->emojiSatisfaccion,
                    'porcentaje' => $level->porcentaje_nivel_satisfaccion,
                    'count' => $counts->get($level->id, 0),
                    'color' => $this->getLevelColor($level->codigoNivelSatisfaccion),
                    'colorLight' => $this->getLevelLightColor($level->codigoNivelSatisfaccion)
                ];
            });
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

    protected function getLevelColor($code)
    {
        return match($code) {
            'NS1' => '#EF4444',
            'NS2' => '#F59E0B',
            'NS3' => '#84CC16',
            'NS4' => '#10B981',
            'NS5' => '#3B82F6',
            default => '#94A3B8'
        };
    }

    protected function getLevelLightColor($code)
    {
        return match($code) {
            'NS1' => '#FEE2E2',
            'NS2' => '#FEF3C7',
            'NS3' => '#DCFCE7',
            'NS4' => '#DBEAFE',
            'NS5' => '#E0E7FF',
            default => '#F3F4F6'
        };
    }
}