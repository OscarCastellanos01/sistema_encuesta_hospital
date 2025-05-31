<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\EncuestaRespuesta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InformeExportPdfController extends Controller
{

    private function nivelesArray($detalles): array
    {
        return [
            $detalles->where('idNivelSatisfaccion', 1)->count(),
            $detalles->where('idNivelSatisfaccion', 2)->count(),
            $detalles->where('idNivelSatisfaccion', 3)->count(),
            $detalles->where('idNivelSatisfaccion', 4)->count(),
            $detalles->where('idNivelSatisfaccion', 5)->count(),
        ];
    }

    private function bucketEdad(int $edad): string
    {
        return match (true) {
            $edad < 18  => '<18',
            $edad < 30  => '18-29',
            $edad < 45  => '30-44',
            $edad < 60  => '45-59',
            default     => '≥60',
        };
    }

    private function normalizaSexo($valor): ?string
    {
        if ($valor === null) {
            return null;
        }

        $v = strtoupper(trim((string) $valor));

        return match (true) {
            $v === '1' || $v === 'M' || str_starts_with($v, 'MASCULINO') || $v === 'HOMBRE' => 'Masculino',
            $v === '2' || $v === 'F' || str_starts_with($v, 'FEMENINO') || $v === 'MUJER'   => 'Femenino',
            default                                                                       => null,
        };
    }

    private function bucketHora(?string $hhmmss): ?string
    {
        if (!$hhmmss) Return null;

        $h = (int) substr($hhmmss, 0, 2);

        return match (true) {
            $h <  7 => null,
            $h < 10 => '07-10',
            $h < 13 => '10-13',
            $h < 16 => '13-16',
            $h < 19 => '16-19',
            $h < 22 => '19-22',
            default => null,
        };
    }

    public function exportPdf(Encuesta $encuesta)
    {
        set_time_limit(300);
        $dateFrom = request('dateFrom');
        $dateTo   = request('dateTo');

        $f1 = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : null;
        $f2 = $dateTo   ? Carbon::parse($dateTo)->endOfDay()   : null;

        $diferenciaDias = 0;
        if ($f1 && $f2) {
            $diferenciaDias = (int) $f1->diffInDays($f2) + 1;
        }

        if ($diferenciaDias >= 14) {
            $semanas = intdiv($diferenciaDias, 7);
            $diasRestantes = $diferenciaDias % 7;
            $textoPeriodo = $semanas . ' semana' . ($semanas > 1 ? 's' : '');
            if ($diasRestantes > 0) {
                $textoPeriodo .= ' y ' . $diasRestantes . ' día' . ($diasRestantes > 1 ? 's' : '');
            }
        }
        elseif ($diferenciaDias >= 7) {
            $semanas = intdiv($diferenciaDias, 7);
            $diasRestantes = $diferenciaDias % 7;
            $textoPeriodo = $semanas . ' semana' . ($semanas > 1 ? 's' : '');
            if ($diasRestantes > 0) {
                $textoPeriodo .= ' y ' . $diasRestantes . ' día' . ($diasRestantes > 1 ? 's' : '');
            }
        }
        else {
            $textoPeriodo = $diferenciaDias . ' día' . ($diferenciaDias > 1 ? 's' : '');
        }

        $query = EncuestaRespuesta::where('idEncuesta', $encuesta->id);

        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom . ' 00:00:00');
        }
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo . ' 23:59:59');
        }

        $respuestas = collect();

        $queryParaChunk = $query
            ->select(['id', 'created_at', 'sexoPaciente', 'edadPaciente'])
            ->with([
                'detalles.pregunta:id,tituloPregunta,tipoPregunta',
                'detalles.nivelSatisfaccion:id,nombreNivelSatisfaccion',
            ])
            ->orderBy('created_at');

        $queryParaChunk->chunk(100, function ($chunk) use ($respuestas) {
            foreach ($chunk as $r) {
                $respuestas->push($r);
            }
        });

        $sexoCounts = ['Masculino'=>0, 'Femenino'=>0];
        foreach ($respuestas as $r) {
            if ($et = $this->normalizaSexo($r->sexoPaciente)) {
                $sexoCounts[$et]++;
            }
        }
        $sexoChart = null;
        if ($sexoCounts['Masculino'] + $sexoCounts['Femenino'] > 0) {
            $sexoChart = 'https://quickchart.io/chart?format=png&w=600&h=300&c='
                . rawurlencode(json_encode([
                    'type'=>'bar',
                    'data'=>[
                        'labels'=>['Masculino','Femenino'],
                        'datasets'=>[[
                            'backgroundColor'=>['#3498db','#e84393'],
                            'data'=>array_values($sexoCounts),
                        ]],
                    ],
                    'options'=>[
                        'title'=>['display'=>true,'text'=>'Distribución por sexo'],
                        'legend'=>['display'=>false],
                        'scales'=>['yAxes'=>[['ticks'=>['beginAtZero'=>true]]]],
                    ],
                ]));
        }

        $edadBuckets = ['<18'=>0,'18-29'=>0,'30-44'=>0,'45-59'=>0,'≥60'=>0];
        foreach ($respuestas as $r) {
            if ($r->edadPaciente !== null) {
                $bucket = $this->bucketEdad((int)$r->edadPaciente);
                $edadBuckets[$bucket]++;
            }
        }

        $edadChart = null;
        if (array_sum($edadBuckets) > 0) {
            $edadChart = 'https://quickchart.io/chart?format=png&w=600&h=300&c='
                . rawurlencode(json_encode([
                    'type'=>'bar',
                    'data'=>[
                        'labels'=>array_keys($edadBuckets),
                        'datasets'=>[[
                            'backgroundColor'=>'#2d98da',
                            'data'=>array_values($edadBuckets),
                        ]],
                    ],
                    'options'=>[
                        'title'=>['display'=>true,'text'=>'Distribución por edad'],
                        'legend'=>['display'=>false],
                        'scales'=>['yAxes'=>[['ticks'=>['beginAtZero'=>true]]]],
                    ],
                ]));
        }

        $porFecha = $respuestas->groupBy(fn($r) =>
            Carbon::parse($r->created_at)
                ->locale('es')
                ->translatedFormat('j \\d\\e F \\d\\e Y')
        );

        $reportData = $porFecha->map(function($coleccion, $fecha) {
            $preguntas = $coleccion->flatMap->detalles
                ->groupBy(fn($d) => $d->pregunta->tituloPregunta)
                ->map(function($detallesPorPregunta) {
                    $tipoP = $detallesPorPregunta->first()->pregunta->tipoPregunta;

                    if ($tipoP === 'texto') {
                        return ['tipo'=>'omit'];
                    }

                    if ($tipoP === 'hora') {
                        $rangos = ['07-10'=>0,'10-13'=>0,'13-16'=>0,'16-19'=>0,'19-22'=>0];
                        foreach ($detallesPorPregunta as $d) {
                            $b = $this->bucketHora($d->respuestaHora);
                            if ($b !== null && isset($rangos[$b])) {
                                $rangos[$b]++;
                            }
                        }
                        return array_sum($rangos) > 0
                            ? ['tipo'=>'hora','rangos'=>$rangos]
                            : ['tipo'=>'omit'];
                    }

                    $niv = $this->nivelesArray($detallesPorPregunta);
                    return array_sum($niv) > 0
                        ? ['tipo'=>'niveles','niveles'=>$niv]
                        : ['tipo'=>'omit'];
                });

            return [
                'fecha' => $fecha,
                'totalEncuestados' => $coleccion->count(),
                'preguntas' => $preguntas,
            ];
        })->values();

        $pdf = Pdf::loadView('informes.encuestas.pdf', [
            'encuesta'   => $encuesta,
            'reportData' => $reportData,
            'sexoChart'  => $sexoChart,
            'edadChart'  => $edadChart,
            'dateFrom'   => $dateFrom,
            'dateTo'     => $dateTo,
            'textoPeriodo' => $textoPeriodo,
        ])
        ->setPaper('a4','portrait')
        ->setOptions([
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
        ]);

        return $pdf->stream('informe_encuesta_'.$encuesta->codigoEncuesta.'.pdf');
    }
}
