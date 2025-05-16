<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12">
        {{-- Encabezado --}}
        <div class="flex items-center space-x-4 mb-10">
            <div class="bg-emerald-600/90 rounded-xl p-4">
                <x-icon name="plus" class="w-8 h-8 text-white" solid />
            </div>
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900">Hospital</h1>
                <p class="text-lg text-slate-600">Encuesta de satisfacción</p>
            </div>
        </div>

        <p class="text-slate-700 mb-10">
            Ayúdenos a mejorar la calidad de nuestro servicio respondiendo esta breve encuesta.
        </p>

        {{-- Bloque de mensajes --}}
        <x-errors class="mb-6" />

        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Preguntas --}}
        <div class="rounded-xl p-6">
            {{-- Encabezado --}}
            <div class="grid gap-4 md:grid-cols-2 mb-6">
                <div>
                    <x-select
                        label="Especialidad"
                        placeholder="Selecciona especialidad"
                        wire:model="especialidad"
                    >
                    @foreach($especialidades as $esp)
                        <x-select.option 
                            value="{{ $esp->id }}" 
                            label="{{ $esp->nombreEspecialidad }}" 
                        />
                    @endforeach
                    </x-select>
                </div>
                <div>
                    <x-input
                        label="Edad del Paciente"
                        type="number"
                        min="0"
                        wire:model="edadPaciente"
                        placeholder="Ingresa la edad"
                    />
                </div>
                <div>
                    <x-select
                        label="Sexo del Paciente"
                        placeholder="Selecciona sexo"
                        wire:model="sexoPaciente"
                        :options="[
                        ['value' => 1, 'label' => 'Masculino'],
                        ['value' => 2, 'label' => 'Femenino'],
                        ]"
                        option-label="label"
                        option-value="value"
                    />
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($preguntas as $pregunta)
                    <div
                        class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between
                        {{ $errors->has('answers.' . $pregunta->id) ? 'ring-2 ring-red-400' : '' }}"
                    >
                        <p 
                            class="font-semibold text-slate-800 mb-6"
                        >
                            {{ $pregunta->tituloPregunta }}
                        </p>
                
                        <div class="flex items-center justify-between">
                            @foreach ($satisfactions as $satisfaccion)
                                <button
                                    type="button"
                                    wire:click="toggleAnswer({{ $pregunta->id }}, {{ $satisfaccion->codigoNivelSatisfaccion }})"
                                    class="text-4xl transition
                                        {{ (isset($answers[$pregunta->id]) && $answers[$pregunta->id] === $satisfaccion->codigoNivelSatisfaccion)
                                            ? 'opacity-100'
                                            : 'opacity-40' }}
                                        cursor-pointer"
                                >
                                    {{ $satisfaccion->emojiSatisfaccion }}
                                </button>
                            @endforeach
                        </div>
                
                        @error('answers.' . $pregunta->id)
                            <span class="text-xs text-red-600 mt-2">Debes responder esta pregunta.</span>
                        @enderror
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Toggle de términos y condicioens --}}
        <div class="mt-8 flex items-center space-x-3">
            <x-toggle wire:model.live="terms" md />
            <span class="text-slate-800">Acepto los términos y condiciones</span>
        </div>
        @error('terms')
            <span class="text-xs text-red-600 mt-2 block">{{ $message }}</span>
        @enderror

        {{-- Botones --}}
        <div class="mt-8 flex flex-col md:flex-row md:justify-end md:space-x-4 space-y-4 md:space-y-0">
            <x-button 
                flat 
                label="Cancelar" 
                wire:click="resetForm" 
                class="w-full md:w-auto"
                spinner="resetForm"
                spinner-target="resetForm"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70"
                wire:target="resetForm" 
            />
            <x-button
                primary
                label="Enviar"
                icon="paper-airplane"
                wire:click="submit"
                class="w-full md:w-auto"
                :disabled="!$terms"
                spinner="submit"
                spinner-target="submit"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70"
                wire:target="submit" 
            />
        </div>
    </div>
</div>
