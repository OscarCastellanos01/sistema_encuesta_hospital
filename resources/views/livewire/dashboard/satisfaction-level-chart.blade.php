<div class="flex justify-center py-10 px-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Niveles de Satisfacción</h2>
        <select wire:model="selectedPeriod" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @foreach($periods as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="h-80">
        <canvas 
            x-data="{
                chart: null,
                init() {
                    this.renderChart();
                    $wire.on('refreshChart', () => {
                        if (this.chart) this.chart.destroy();
                        this.renderChart();
                    });
                },
                renderChart() {
                    const chartData = @js($chartData);
                    
                    // Configuración personalizada para mostrar emojis
                    const emojiPlugin = {
                        id: 'emojiPlugin',
                        afterDraw(chart) {
                            const ctx = chart.ctx;
                            const { datasets } = chart.data;
                            const { emojis } = chartData;
                            
                            chart.getDatasetMeta(0).data.forEach((element, index) => {
                                const { x, y } = element.tooltipPosition();
                                const emoji = emojis[index];
                                const value = datasets[0].data[index];
                                
                                if (value > 0) {
                                    ctx.font = '20px Arial';
                                    ctx.textAlign = 'center';
                                    ctx.fillText(emoji, x, y - 25);
                                }
                            });
                        }
                    };
                    
                    this.chart = new Chart(this.$el, {
                        type: 'doughnut',
                        data: {
                            labels: chartData.labels,
                            datasets: chartData.datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        generateLabels: function(chart) {
                                            const data = chart.data;
                                            return data.labels.map((label, i) => {
                                                const emoji = chartData.emojis[i];
                                                return {
                                                    text: `${emoji} ${label}: ${data.datasets[0].data[i]}`,
                                                    fillStyle: data.datasets[0].backgroundColor[i],
                                                    hidden: false,
                                                    index: i
                                                };
                                            });
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = Math.round((value / total) * 100);
                                            return `${label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        },
                        plugins: [emojiPlugin]
                    });
                }
            }"
            x-init="init"
            wire:ignore
        ></canvas>
    </div>
</div>