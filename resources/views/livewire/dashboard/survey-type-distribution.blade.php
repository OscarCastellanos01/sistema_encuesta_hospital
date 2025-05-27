<div class="flex justify-center py-10 px-4">
    <div
        class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">

        <h2 class="text-lg font-semibold text-gray-800 mb-4">Distribución por Tipo de Encuesta</h2>

        <div class="grid grid-cols-1 gap-6">
            

            <div>
                <h3 class="text-md font-medium text-gray-700 mb-3">Detalles</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total de Encuestas</span>
                        <span class="text-sm font-medium">{{ $totalSurveys }}</span>
                    </div>

                    @foreach ($chartData['labels'] as $index => $label)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm text-gray-600">{{ $label }}</span>
                                <span class="text-sm font-medium">
                                    {{ $chartData['datasets'][0]['data'][$index] }}
                                    ({{ round(($chartData['datasets'][0]['data'][$index] / $totalSurveys) * 100, 1) }}%)
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full"
                                    style="width: {{ ($chartData['datasets'][0]['data'][$index] / $totalSurveys) * 100 }}%; background-color: {{ $chartData['datasets'][0]['backgroundColor'][$index] }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
