<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Niveles de Satisfacción</h2>
            <select wire:model="selectedPeriod" 
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @foreach ($periods as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 gap-6">
        <!-- Listado detallado -->
        <x-card title="Detalle por Niveles" class="p-6">
            <div class="grid grid-cols-1 gap-4">
                @foreach($satisfactionLevels as $level)
                    <div class="p-4 rounded-lg" style="background-color: {{ $level->colorLight }}; border-left: 4px solid {{ $level->color }};">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">{{ $level->emoji }}</span>
                                <div>
                                    <h3 class="font-semibold">{{ $level->nombre }}</h3>
                                    <p class="text-sm text-gray-600">{{ $level->porcentaje }}% satisfacción</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full" style="color: {{ $level->color }}; background-color: white;">
                                {{ $level->codigo }}
                            </span>
                        </div>
                        @if($totalResponses > 0)
                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span>{{ $level->count }} respuestas</span>
                                <span class="font-medium">{{ round(($level->count / $totalResponses) * 100) }}% del total</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full" 
                                     style="width: {{ ($level->count / $totalResponses) * 100 }}%; background-color: {{ $level->color }};"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>    
    </div>
</div>