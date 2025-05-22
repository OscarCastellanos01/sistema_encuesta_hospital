<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\EncuestaRespuesta;
use App\Models\RegistroFacilitador;

class StatsOverview extends Component
{
    public function render()
    {
        return view('livewire.dashboard.stats-overview', [
            'totalSurveys' => Encuesta::count(),
            'totalResponses' => EncuestaRespuesta::count(),
            'activeFacilitators' => $this->getActiveFacilitatorsCount(),
            'satisfactionRate' => $this->getAverageSatisfaction(),
            'responseRate' => $this->calculateResponseRate()
        ]);
    }

    protected function getActiveFacilitatorsCount()
    {
        // Contar usuarios únicos con encuestas asignadas
        return RegistroFacilitador::distinct('idUsuario')->count('idUsuario');
    }

    protected function getAverageSatisfaction()
    {
        // Implementación básica - ajustar según tu estructura real
        $average = EncuestaRespuesta::has('detalles')
            ->with('detalles.nivelSatisfaccion')
            ->get()
            ->flatMap(function($respuesta) {
                return $respuesta->detalles
                    ->filter(fn($d) => $d->nivelSatisfaccion)
                    ->map(fn($d) => $this->mapSatisfactionValue($d->nivelSatisfaccion));
            })
            ->avg();

        return number_format($average ?? 0, 1);
    }

    protected function mapSatisfactionValue($nivel)
    {
        return match($nivel->codigoNivelSatisfaccion) {
            'NS1' => 1, // Muy insatisfecho
            'NS2' => 2, // Insatisfecho
            'NS3' => 3, // Neutral
            'NS4' => 4, // Satisfecho
            'NS5' => 5, // Muy satisfecho
            default => 0
        };
    }

    protected function calculateResponseRate()
    {
        $totalSurveys = Encuesta::count();
        $totalResponses = EncuestaRespuesta::count();
        
        return $totalSurveys > 0 
            ? number_format(($totalResponses / $totalSurveys) * 100, 1)
            : 0;
    }
}