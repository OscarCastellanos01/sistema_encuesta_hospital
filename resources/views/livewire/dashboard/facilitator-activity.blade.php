<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
        <!-- Encabezado con título y selectores -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-800">Actividad de Facilitadores</h2>
            
            <div class="flex flex-col sm:flex-row gap-3 items-center">
                <!-- Selector de rango de tiempo -->
                <div class="relative">
                    <select wire:model.live="timeRange" 
                            wire:loading.attr="disabled"
                            class="appearance-none border border-gray-300 rounded-md pl-3 pr-8 py-2 text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($timeRanges as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Spinner de carga -->
                <div wire:loading class="ml-2">
                    <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Texto descriptivo del período -->
        @if($currentPeriodText)
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Mostrando datos: <span class="font-medium">{{ $currentPeriodText }}</span>
                    </p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Contenido principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sección de Registros por día -->
            <x-card title="Registros por día" class="p-6">
                @if(count($activity) > 0)
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">
                                Distribución diaria
                            </span>
                            <span class="text-sm font-medium text-indigo-600">
                                Total: {{ array_sum(array_column($activity->toArray(), 'count')) }} registros
                            </span>
                        </div>
                        
                        <div class="h-64 overflow-y-auto pr-2 space-y-3">
                            @foreach($activity as $day)
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-medium text-gray-800">{{ $day['date'] }}</span>
                                        <span class="text-sm bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">
                                            {{ $day['count'] }} registros
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full bg-indigo-500" 
                                             style="width: {{ min(($day['count'] / $maxDailyCount) * 100, 100) }}%"
                                             title="{{ $day['count'] }} registros ({{ round(($day['count'] / $maxDailyCount) * 100) }}% del día con más registros)">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="h-64 flex flex-col items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-center">No hay datos disponibles</p>
                        <p class="text-sm text-center">para el período seleccionado</p>
                    </div>
                @endif
            </x-card>

            <!-- Sección de Top Facilitadores -->
            <x-card title="Top Facilitadores" class="p-6">
                @if(count($topFacilitators) > 0)
                    <div class="space-y-3">
                        @foreach($topFacilitators as $f)
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm hover:shadow transition-shadow">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-indigo-100 text-indigo-800 rounded-full h-10 w-10 flex items-center justify-center">
                                        <x-icon name="user" class="w-5 h-5 text-current" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $f->facilitator_name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $f->response_count }} {{ Str::plural('encuesta', $f->response_count) }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-indigo-600 text-white">
                                    #{{ $loop->iteration }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-full flex flex-col items-center justify-center py-8 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-center">No hay registros</p>
                        <p class="text-sm text-center">de facilitadores disponibles</p>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</div>