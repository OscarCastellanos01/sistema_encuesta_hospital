<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold">Actividad de Facilitadores</h2>

            <div class="w-full md:w-48">
                <x-select
                    wire:model="timeRange"
                    label="Rango de tiempo"
                    placeholder="Selecciona un rango"
                >
                    @foreach($timeRanges as $value => $label)
                        <x-select :value="$value" :label="$label" />
                    @endforeach
                </x-select>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
                                    data: { labels, datasets: [{
                                        label: 'Encuestas',
                                        data: counts,
                                        backgroundColor: '#6366F1',
                                        borderColor: '#6366F1',
                                        borderWidth: 1
                                    }]},
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: { beginAtZero: true, ticks: { stepSize: 1 } }
                                        }
                                    }
                                });
                            }
                        }"
                        x-init="init"
                        wire:ignore
                    ></canvas>
                </div>
            </x-card>

            <x-card title="Top Facilitadores" class="space-y-4">
                @forelse($topFacilitators as $f)
                    <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                        <div class="flex items-center space-x-4">
                            <div class="bg-indigo-100 text-indigo-800 rounded-full h-10 w-10 flex items-center justify-center">
                                <span class="text-xl">{{ $f->emoji ?? '❓' }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $f->facilitator_name }}</p>
                                <p class="text-sm text-gray-500">{{ $f->response_count }} encuestas</p>
                            </div>
                        </div>
                        <x-badge
                            :label="number_format($f->avg_satisfaction, 1) . '/5'"
                            :color="$f->avg_satisfaction >= 4 ? 'green' : ($f->avg_satisfaction >= 3 ? 'yellow' : 'red')"
                            class="font-medium"
                        />
                    </div>
                @empty
                <x-alert
                    icon="information-circle"
                    title="Sin datos"
                    type="info"
                >
                    No hay registros de facilitadores disponibles.
                </x-alert>
                @endforelse
            </x-card>
        </div>
    </div>
</div>
