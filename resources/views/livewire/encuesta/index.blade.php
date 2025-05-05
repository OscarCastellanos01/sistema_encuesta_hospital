<div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-[#e8f1f5] to-[#dfe9ef] py-10">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-[95%] max-w-[1100px] px-10 py-12">
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

        {{-- Bloque de errores --}}
        <x-errors class="mb-6" />

        {{-- Datos auxiliares --}}
        @php
            // Preguntas
            $items = [
                'wait_time'   => 'Tiempo de espera',
                'doctor_care' => 'Trato del doctor',
                'nurse_care'  => 'Atención de enfermería',
                'cleanliness' => 'Limpieza',
            ];

            $faces = [
                1 => ['emoji' => '😡', 'ring' => 'ring-red-600'],
                2 => ['emoji' => '😞', 'ring' => 'ring-orange-500'],
                3 => ['emoji' => '😐', 'ring' => 'ring-yellow-500'],
                4 => ['emoji' => '😊', 'ring' => 'ring-lime-600'],
                5 => ['emoji' => '😁', 'ring' => 'ring-green-600'],
            ];

            // Etiquetas de escala (por si se necesita más tarde)
            $labels = [
                1 => 'Muy insatisfecho',
                2 => 'Insatisfecho',
                3 => 'Neutral',
                4 => 'Satisfecho',
                5 => 'Muy satisfecho',
            ];
        @endphp

        {{-- Preguntas --}}
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($items as $key => $label)
                @php
                    $hasError = $errors->has('answers.' . $key);
                @endphp

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between
                    @if($hasError) ring-2 ring-red-400 @endif"
                >
                    <p class="font-semibold text-slate-800 mb-6">{{ $label }}</p>

                    <div class="flex items-center justify-between">
                        @foreach ($faces as $value => $data)
                            @php
                                $inputId   = "answers_{$key}_{$value}";
                                $inputName = "answers[{$key}]";
                            @endphp

                            <label for="{{ $inputId }}" class="cursor-pointer">
                                <input
                                    id="{{ $inputId }}"
                                    name="{{ $inputName }}"
                                    type="radio"
                                    value="{{ $value }}"
                                    class="sr-only peer"
                                    wire:model.defer="answers.{{ $key }}"
                                >

                                <span class="text-4xl transition opacity-40 peer-checked:opacity-100">
                                    {{ $data['emoji'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    {{-- Error individual --}}
                    @error('answers.' . $key)
                        <span class="text-xs text-red-600 mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach
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
            <x-button flat label="Cancelar" wire:click="resetForm" class="w-full md:w-auto" />
            <x-button
                primary
                label="Enviar"
                icon="paper-airplane"
                wire:click="submit"
                class="w-full md:w-auto"
                :disabled="!$terms"
            />
        </div>
    </div>
</div>
