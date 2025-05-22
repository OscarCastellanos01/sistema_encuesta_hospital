<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\tipo_encuesta;
use App\Models\Encuesta;

class SurveyTypeDistribution extends Component
{
    public function render()
    {
        // Opción 1: Usando withCount (más eficiente)
        $types = tipo_encuesta::withCount('encuestas')->get();
        
        // Opción 2: Si necesitas más control o relaciones adicionales
        // $types = tipo_encuesta::with(['encuestas'])->get()->map(function($type) {
        //     $type->encuestas_count = $type->encuestas->count();
        //     return $type;
        // });

        $totalSurveys = Encuesta::count();

        $chartData = [
            'labels' => $types->pluck('nombreTipoEncuesta'),
            'datasets' => [
                [
                    'label' => 'Encuestas por Tipo',
                    'data' => $types->pluck('encuestas_count'),
                    'backgroundColor' => $this->generateColors($types->count()),
                    'borderWidth' => 1
                ]
            ]
        ];

        return view('livewire.dashboard.survey-type-distribution', [
            'chartData' => $chartData,
            'totalSurveys' => $totalSurveys
        ]);
    }

    protected function generateColors($count)
    {
        // Colores base de Tailwind
        $baseColors = ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6'];
        
        // Si hay más tipos que colores base, repetimos o generamos nuevos
        if ($count <= count($baseColors)) {
            return array_slice($baseColors, 0, $count);
        }
        
        // Generar colores adicionales si es necesario
        $colors = $baseColors;
        for ($i = count($baseColors); $i < $count; $i++) {
            $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        
        return $colors;
    }
}