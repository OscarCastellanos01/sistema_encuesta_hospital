<div class="flex justify-center py-10 px-4">

    {{-- Card principal --}}
    <x-card class="space-y-6">

        {{-- Cabecera con título y filtro --}}
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">Actividad de Facilitadores</h2>

            <x-select
                label="Rango de tiempo"
                wire:model="timeRange"
                class="w-48"
            >
                @foreach($timeRanges as $value => $label)
                    <x-select.option :value="$value" :label="$label" />
                @endforeach
            </x-select>
        </div>

        {{-- Gráfica y Top facilitadores --}}
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-2">

            {{-- Chart --}}
            <x-card title="Registros por día" class="p-0">
                <div class="h-64">
                    <canvas
                        x-data="{
                            chart: null,
                            init() {
                                this.renderChart();
                                $wire.on('refreshChart', () => {
                                    this.chart?.destroy();
                                    this.renderChart();
                                });
                            },
                            renderChart() {
                                const data = @js($activity);
                                const labels = data.map(i => new Date(i.date).toLocaleDateString());
                                const counts = data.map(i => i.count);

                                this.chart = new Chart($el, {
                                    type: 'bar',
                                    data: {
                                        labels,
                                        datasets: [{ 
                                            label: 'Encuestas', 
                                            data: counts,
                                            backgroundColor: '#6366F1',
                                            borderColor: '#6366F1',
                                            borderWidth: 1 
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                                    }
                                });
                            }
                        }"
                        x-init="init"
                        wire:ignore
                    ></canvas>
                </div>
            </x-card>

            {{-- Top Facilitadores --}}
            <x-card title="Top Facilitadores" class="space-y-4">

                @forelse($topFacilitators as $f)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="bg-indigo-100 text-indigo-800 rounded-full h-10 w-10 flex items-center justify-center">
                                <span class="text-xl">{{ $f->emoji ?? '❓' }}</span>
                            </div>
                            <div>
                                <p class="font-medium">{{ $f->facilitator_name }}</p>
                                <p class="text-xs text-gray-500">{{ $f->response_count }} encuestas</p>
                            </div>
                        </div>
                        <x-badge
                            :label="number_format($f->avg_satisfaction, 1) . '/5'"
                            :color="$f->avg_satisfaction >= 4 ? 'green' : ($f->avg_satisfaction >= 3 ? 'yellow' : 'red')"
                        />
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No hay datos de facilitadores</p>
                @endforelse

            </x-card>
        </div>
    </x-card>
</div>