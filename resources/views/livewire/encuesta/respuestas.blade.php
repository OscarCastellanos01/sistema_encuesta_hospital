<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
  
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold">Respuestas: {{ $encuesta->tituloEncuesta }}</h2>
                @if($encuesta->estadoEncuesta)
                    <x-badge flat green label="Activo" />
                @else
                    <x-badge flat red label="Inactivo" />
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 items-end">
            <div>
                <x-input
                    label="Buscar código"
                    placeholder="ER-00001"
                    wire:model.live="search"
                />
            </div>

            <div>
                <x-input
                    type="date"
                    label="Desde"
                    wire:model.live="dateFrom"
                />
            </div>

            <div>
                <x-input
                    type="date"
                    label="Hasta"
                    wire:model.live="dateTo"
                />
            </div>
        </div>
  
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                            Código
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                            Edad
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                            Sexo
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                            Fecha
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                            Detalle
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($responses as $resp)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $resp->codigoEncuestaRespuesta }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $resp->edadPaciente }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $resp->sexoPaciente == 1 ? 'Masculino' : 'Femenino' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $resp->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button 
                                    wire:click="toggleExpand({{ $resp->id }})" 
                                    class="p-1 rounded hover:bg-gray-200"
                                >
                                    @if($expandedId === $resp->id)
                                        <x-icon name="chevron-up" class="h-5 w-5 text-blue-600" />
                                    @else
                                        <x-icon name="chevron-down" class="h-5 w-5 text-blue-600" />
                                    @endif
                                </button>
                            </td>
                        </tr>
        
                        @if($expandedId === $resp->id)
                            <tr class="bg-gray-100">
                                <td colspan="5" class="px-4 py-4">
                                    <ul class="divide-y divide-gray-200 space-y-4">
                                        @foreach($resp->detalles as $det)
                                            <li>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $det->pregunta->tituloPregunta }}
                                                </p>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="text-2xl">
                                                        {{ $det->nivelSatisfaccion->emojiSatisfaccion }}
                                                    </span>
                                                    <span class="text-sm text-gray-700">
                                                        {{ $faceLabels[$det->nivelSatisfaccion->nombreNivelSatisfaccion] }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
  
        {{-- Paginación --}}
        <div class="mt-4">
            {{ $responses->links() }}
        </div>
    </div>
</div>
  