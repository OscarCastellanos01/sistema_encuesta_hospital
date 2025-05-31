<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 1.5cm; }
        body { font-family: DejaVu Sans, sans-serif; font-size:11px; line-height:1.4; }
        h1, h2 { text-align:center; margin:0; }
        h1 { font-size:18px; }
        h2 { font-size:14px; margin-top:1em; }
        h3 { font-size:12px; margin:0.8em 0 0.4em; }
        p  { margin:0.3em 0; text-align:justify; }
        table { width:100%; border-collapse:collapse; margin-top:0.5em; }
        th, td { border:1px solid #000; padding:4px; }
        th { background:#eee; }
        .page-break { page-break-after:always; }
    </style>
</head>
<body>
    @php
        use Carbon\Carbon;

        $df = $dateFrom ?? null; 
        $dt = $dateTo   ?? null;

        $f1 = ($df && trim($df) !== '') ? Carbon::parse($df)->locale('es') : null;
        $f2 = ($dt && trim($dt) !== '') ? Carbon::parse($dt)->locale('es') : null;

        if ($f1 && $f2) {
            $textoRango = $f1->translatedFormat('j \\d\\e F \\d\\e Y')
                        . ' – '
                        . $f2->translatedFormat('j \\d\\e F \\d\\e Y');
        }
        elseif ($f1) {
            $textoRango = 'Desde ' . $f1->translatedFormat('j \\d\\e F \\d\\e Y');
        }
        elseif ($f2) {
            $textoRango = 'Hasta ' . $f2->translatedFormat('j \\d\\e F \\d\\e Y');
        }
        else {
            $textoRango = Carbon::now()->locale('es')->translatedFormat('F Y');
        }
    @endphp

    <header>
        <h1>INFORME DE TABULACIÓN DE DATOS</h1>
        <p>{{ $textoRango }}</p>
    </header>

    <section>
        {!! nl2br(e("
    El presente informe de tabulación de datos se refiere a las encuestas realizadas durante un período de {$textoPeriodo} en el Hospital de El Progreso, con el propósito de evaluar la calidad de atención proporcionada a los pacientes. Este estudio se llevó a cabo con el fin de identificar áreas de mejora y fortalecer los servicios ofrecidos en esta institución de salud.

    Durante el mencionado lapso, se implementó un detallado proceso de recolección de datos a través de encuestas diseñadas específicamente para capturar las percepciones y experiencias de los pacientes en relación con la atención recibida en el hospital. La participación activa de los pacientes en este proceso ha proporcionado valiosa información que permitirá un análisis objetivo de la calidad de los servicios brindados.

    Los datos recopilados fueron meticulosamente tabulados y analizados para identificar tendencias, puntos destacados y áreas de oportunidad. El objetivo de este informe es presentar de manera clara y concisa los resultados obtenidos, resaltando tanto los aspectos en los que se ha demostrado excelencia como aquellos en los que se pueden concentrar esfuerzos para lograr una mejora continua.

    Se agradece sinceramente la colaboración de todos los participantes en este proceso, cuyas opiniones y comentarios han brindado una visión integral de la percepción de la calidad de atención en el Hospital de El Progreso. Se confía en que este informe sea una herramienta útil para orientar las acciones futuras y reafirmar el compromiso de la institución con la excelencia en el cuidado de la salud de la comunidad.

    Sin más preámbulos, se invita a los lectores a sumergirse en los resultados de esta evaluación y a unirse en el compromiso de elevar los estándares de calidad en el Hospital de El Progreso.
    ")) !!}
    </section>

    @foreach($reportData as $dia)
        <section class="page-break">
            <h2>{{ strtoupper($dia['fecha']) }}</h2>
            <p>Total de encuestados: <strong>{{ $dia['totalEncuestados'] }}</strong></p>

            @foreach($dia['preguntas'] as $titulo => $info)

                @if($info['tipo'] === 'omit')
                    @continue
                @endif

                @if($info['tipo'] === 'niveles')
                    @php
                        $niveles = $info['niveles']; 
                        $labels  = ['Muy insatisfecho','Insatisfecho','Neutral','Satisfecho','Muy satisfecho'];
                        $colors  = ['#c0392b','#e74c3c','#f1c40f','#27ae60','#1e7c1e'];

                        $urlNiv = 'https://quickchart.io/chart?format=png&w=650&h=300&c='
                            . rawurlencode(json_encode([
                                'type'=>'bar',
                                'data'=>[
                                    'labels'=>$labels,
                                    'datasets'=>[[
                                        'backgroundColor'=>$colors,
                                        'data'=>$niveles
                                    ]],
                                ],
                                'options'=>[
                                    'title'=>['display'=>true,'text'=>mb_strtoupper($titulo)],
                                    'legend'=>['display'=>false],
                                    'scales'=>['yAxes'=>[['ticks'=>['beginAtZero'=>true]]]],
                                ],
                            ]));

                        $pctSat = array_sum($niveles) 
                                ? round(( $niveles[3] + $niveles[4] ) * 100 / array_sum($niveles), 1)
                                : 0;
                    @endphp

                    <p style="text-align:center; margin:0.6em 0;">
                        <img src="{{ $urlNiv }}" style="max-width:100%;" alt="Gráfica {{ $titulo }}">
                    </p>

                    <p>
                        <strong>NOTA:</strong>
                        Las personas que utilizaron el servicio de <strong>{{ $titulo }}</strong>
                        mostraron un 
                        @if($pctSat >= 80) 
                            <u>alto</u>
                        @elseif($pctSat >= 60) 
                            <u>medio</u>
                        @else 
                            <u>bajo</u>
                        @endif 
                        nivel de satisfacción ({{ $pctSat }} %).  
                        Se trabaja en conjunto con el comité de calidad para motivar al personal y aplicar planes de mejora.
                    </p>
                @endif

                @if($info['tipo'] === 'hora')
                    @php
                        $rangos = $info['rangos'];
                        if (array_sum($rangos) == 0) {
                            $urlHora = null;
                        } else {
                            $urlHora = 'https://quickchart.io/chart?format=png&w=650&h=300&c='
                                . rawurlencode(json_encode([
                                    'type'=>'bar',
                                    'data'=>[
                                        'labels'=>array_keys($rangos),
                                        'datasets'=>[[
                                            'backgroundColor'=>'#16a085',
                                            'data'=>array_values($rangos),
                                        ]],
                                    ],
                                    'options'=>[
                                        'title'=>['display'=>true,'text'=>mb_strtoupper($titulo)],
                                        'legend'=>['display'=>false],
                                        'scales'=>['yAxes'=>[['ticks'=>['beginAtZero'=>true]]]],
                                    ],
                                ]));
                        }
                    @endphp

                    @if(isset($urlHora))
                        <p style="text-align:center; margin:0.6em 0;">
                            <img src="{{ $urlHora }}" style="max-width:100%;" alt="Gráfica {{ $titulo }}">
                        </p>
                    @endif
                @endif
            @endforeach
        </section>
    @endforeach

    <section class="page-break">
        <h2>Distribución demográfica de los encuestados</h2>
        <div style="display:flex; justify-content:center; align-items:center; gap:2%;">
            @if(!is_null($sexoChart))
                <div style="width:45%;">
                    <img src="{{ $sexoChart }}" style="width:100%;" alt="Distribución por sexo">
                </div>
            @endif

            @if(!is_null($edadChart))
                <div style="width:45%;">
                    <img src="{{ $edadChart }}" style="width:100%;" alt="Distribución por edad">
                </div>
            @endif
        </div>
    </section>

    <section>
        <h2>CONCLUSIÓN</h2>
        <p>
            Las encuestas realizadas para evaluar la calidad de atención en el Hospital de El Progreso fueron llevadas a cabo por la Unidad de UISAU de la institución y analizadas por dicho equipo. Los resultados obtenidos serán utilizados para la implementación de acciones de mejora en colaboración con el Comité de Calidad, reafirmando así el compromiso del hospital con la excelencia en el cuidado de la salud de nuestra comunidad.
        </p>
        <p><strong>Elaborado por:</strong><br>
        Licda.&nbsp;Vanessa&nbsp;Yureyda&nbsp;Contreras&nbsp;Lázaro – Coordinadora/UISAU
        </p>
        <p><strong>Vo. Bo.:</strong> Dra.&nbsp;Mara&nbsp;Judith&nbsp;Gómez&nbsp;Balcárcel – Directora</p>
    </section>
</body>
</html>
