<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold">Actividad de Facilitadores</h2>
            
            <!-- Selector de rango de tiempo mejorado -->
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Mostrar:</span>
                <select wire:model.live="timeRange" 
                        wire:loading.attr="disabled"
                        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($timeRanges as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <div wire:loading>
                    <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Registros por día -->
            <x-card title="Registros por día" class="p-6">
                @if(count($activity) > 0)
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">
                                Período seleccionado: {{ $timeRanges[$timeRange] }}
                            </span>
                            <span class="text-sm font-medium text-indigo-600">
                                Total: {{ array_sum(array_column($activity->toArray(), 'count')) }} registros
                            </span>
                        </div>
                        
                        <div class="h-64 overflow-y-auto pr-2">
                            @foreach($activity as $day)
                                <div class="space-y-1 mb-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="font-medium">{{ $day['date'] }}</span>
                                        <span>{{ $day['count'] }} registros</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full bg-indigo-500" 
                                             style="width: {{ min(($day['count'] / $maxDailyCount) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="h-64 flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>No hay datos disponibles para este período</p>
                        </div>
                    </div>
                @endif
            </x-card>

            <!-- Top Facilitadores -->
            <x-card title="Top Facilitadores" class="space-y-4">
                @forelse($topFacilitators as $f)
                    <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-4">
                            <div class="bg-indigo-100 text-indigo-800 rounded-full h-10 w-10 flex items-center justify-center">
                               <x-icon name="user" class="w-6 h-6 text-current" />
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $f->facilitator_name }}</p>
                                <p class="text-sm text-gray-500">{{ $f->response_count }} encuestas</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-800">
                            {{ $loop->iteration }}°
                        </span>
                    </div>
                @empty
                    <x-alert icon="information-circle" title="Sin datos" type="info">
                        No hay registros de facilitadores disponibles.
                    </x-alert>
                @endforelse
            </x-card>
        </div>
    </div>
</div>