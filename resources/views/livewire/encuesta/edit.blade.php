<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
  
        {{-- Mensajes --}}
        @if(session()->has('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif
  
        <form wire:submit.prevent="save" class="space-y-8">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input 
                        label="Título de la Encuesta"
                        wire:model.defer="tituloEncuesta"
                    />
                    @error('tituloEncuesta')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-input 
                        label="Descripción"
                        wire:model.defer="descripcionEncuesta" 
                    />
                    @error('descripcionEncuesta')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
    
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <x-native-select
                        label="Área"
                        wire:model="idArea"
                    >
                        <option value="" disabled>Selecciona área</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">
                                {{ $area->nombreArea }}
                            </option>
                        @endforeach
                    </x-native-select>
                    @error('idArea') 
                        <span class="text-xs text-red-600">{{ $message }}</span> 
                    @enderror
                </div>
                <div>
                    <x-native-select
                        label="Tipo de Encuesta"
                        wire:model="idTipoEncuesta"
                    >
                        <option value="" disabled>Selecciona tipo de encuesta</option>
                        @foreach($tiposEncuesta as $t)
                            <option value="{{ $t->id }}">
                                {{ $t->nombreTipoEncuesta }}
                            </option>
                        @endforeach
                    </x-native-select>
                    @error('idTipoEncuesta') 
                        <span class="text-xs text-red-600">{{ $message }}</span> 
                    @enderror
                </div>
                <div>
                    <x-native-select
                        label="Tipo de Cita"
                        wire:model="idTipoCita"
                    >
                        <option value="" disabled>Selecciona tipo de cita</option>
                        @foreach($tiposCita as $tc)
                            <option value="{{ $tc->id }}">
                                {{ $tc->tipoCita }}
                            </option>
                        @endforeach
                    </x-native-select>
                    @error('idTipoCita')
                        <span class="text-xs text-red-600">{{ $message }}</span> 
                    @enderror
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Preguntas</h2>
                    <x-button 
                        flat 
                        icon="plus" 
                        label="Añadir Pregunta" 
                        wire:click.prevent="addQuestion" 
                    />
                </div>
    
                <div class="grid gap-6">
                    @foreach($questions as $idx => $q)
                        <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col space-y-4 {{ $errors->has("questions.{$idx}.titulo") ? 'ring-2 ring-red-400' : '' }}">
                            
                            @if($q['id'])
                                <input type="hidden" wire:model.defer="questions.{{ $idx }}.id" />
                            @endif
            
                            <x-input 
                                label="Pregunta {{ $idx + 1 }}"
                                wire:model.defer="questions.{{ $idx }}.titulo"
                            />
                            @error("questions.{$idx}.titulo")
                                <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
            
                            <div class="flex items-center space-x-2">
                                <x-toggle 
                                    label="Activo"
                                    on-label="Sí"
                                    off-label="No"
                                    wire:model.defer="questions.{{ $idx }}.estado" 
                                />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    
            <div class="flex justify-end">
                <x-button 
                    primary 
                    label="Actualizar Encuesta" 
                    type="submit"
                    spinner="save" 
                    spinner-target="save"
                    wire:loading.attr="disabled" 
                />
            </div>
        </form>
    </div>
</div>
