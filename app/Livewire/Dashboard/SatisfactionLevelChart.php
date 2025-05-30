<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\nivel_satisfaccion;

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
        $satisfactionLevels = $this->getSatisfactionLevelsWithStats();
        
        return view('livewire.dashboard.satisfaction-level-chart', [
            'satisfactionLevels' => $satisfactionLevels,
            'totalResponses' => $satisfactionLevels->sum('count'),
            'periods' => [
                'week' => 'Esta semana',
                'month' => 'Este mes',
                'year' => 'Este año',
                'all' => 'Todos'
            ]
        ]);
    }

    protected function getSatisfactionLevelsWithStats()
    {
        return nivel_satisfaccion::query()
            ->where('estadoNivelSatisfaccion', 1)
            ->orderBy('codigoNivelSatisfaccion')
            ->get()
            ->map(function($level) {
                // Aquí deberías reemplazar esto con tu lógica real para contar respuestas
                $count = rand(5, 20); // Ejemplo con datos aleatorios
                
                return (object) [
                    'id' => $level->id,
                    'codigo' => $level->codigoNivelSatisfaccion,
                    'nombre' => $level->nombreNivelSatisfaccion,
                    'emoji' => $level->emojiSatisfaccion,
                    'porcentaje' => $level->porcentaje_nivel_satisfaccion,
                    'count' => $count,
                    'color' => $this->getLevelColor($level->codigoNivelSatisfaccion),
                    'colorLight' => $this->getLevelLightColor($level->codigoNivelSatisfaccion)
                ];
            });
    }

    protected function getLevelColor($code)
    {
        return match($code) {
            'NS1' => '#EF4444', // Rojo
            'NS2' => '#F59E0B', // Amarillo
            'NS3' => '#84CC16', // Verde claro
            'NS4' => '#10B981', // Verde
            'NS5' => '#3B82F6', // Azul
            default => '#94A3B8' // Gris
        };
    }

    protected function getLevelLightColor($code)
    {
        return match($code) {
            'NS1' => '#FEE2E2', // Rojo claro
            'NS2' => '#FEF3C7', // Amarillo claro
            'NS3' => '#DCFCE7', // Verde claro
            'NS4' => '#DBEAFE', // Azul claro
            'NS5' => '#E0E7FF', // Indigo claro
            default => '#F3F4F6' // Gris claro
        };
    }
}