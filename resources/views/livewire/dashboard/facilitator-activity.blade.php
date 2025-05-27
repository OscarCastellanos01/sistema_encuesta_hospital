<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold">Actividad de Facilitadores</h2>

            <div class="w-full md:w-48">
                <select wire:model="timeRange"
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach ($timeRanges as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-card title="Registros por día" class="p-0">
                <div class="h-64">
                    <canvas id="myChart"></canvas>
                </div>
            </x-card>

            <x-card title="Top Facilitadores" class="space-y-4">
                @forelse($topFacilitators as $f)
                    <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                        <div class="flex items-center space-x-4">
                            <div class="bg-indigo-100 text-indigo-800 rounded-full h-10 w-10 flex items-center justify-center">
                               <x-icon name="user" class="w-6 h-6 text-current" />
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $f->facilitator_name }}</p>
                                <p class="text-sm text-gray-500">{{ $f->response_count }} encuestas</p>
                            </div>
                        </div>
                    </div>
                @empty
                <x-alert
                    icon="information-circle"
                    title="Sin datos"
                    type="info">
                    No hay registros de facilitadores disponibles.
                </x-alert>
                @endforelse
            </x-card>
        </div>
    </div>
   @push('scripts')
    {{-- Cargar Chart.js desde CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
        document.addEventListener('livewire:load', () => {
            const ctx = document.getElementById('myChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Muy insatisfecho', 'Insatisfecho', 'Neutral', 'Satisfecho', 'Muy satisfecho'],
                    datasets: [{
                        label: 'Niveles de Satisfacción',
                        data: [1, 2, 3, 4, 5], // Cambia esto por tus datos reales
                        backgroundColor: [
                            '#ef4444', // rojo
                            '#f97316', // naranja
                            '#facc15', // amarillo
                            '#10b981', // verde
                            '#3b82f6'  // azul
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
        </script>
    @endpush

</div>
