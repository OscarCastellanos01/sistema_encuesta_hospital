<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12">

        <div class="sticky top-4 z-10 p-4 rounded-xl">
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
            <form 
                wire:submit.prevent="save"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 items-end"
            >
                <div class="md:col-span-3">
                    <x-input
                        label="Tipo de Encuesta"
                        placeholder="Escribe el nombre…"
                        wire:model.defer="nombreTipoEncuesta"
                    />
                </div>

                <div class="flex items-center">
                    <x-toggle
                        label="Estado"
                        on-label="Activo"
                        off-label="Inactivo"
                        wire:model.defer="estado"
                    />
                </div>

                <div class="md:col-span-4 flex justify-end">
                    <x-button
                        type="submit"
                        primary
                        label="{{ $tipoId ? 'Actualizar' : 'Crear' }}"
                        spinner="save"
                        spinner-target="save"
                    />
                </div>
            </form>
        </div>

        <div class="mt-6 overflow-y-auto" style="max-height: 400px;">
            <ul class="divide-y divide-gray-200">
                @foreach($tipos as $tipo)
                    <li class="flex items-center justify-between py-4">
                        <div class="flex items-center">
                            <x-avatar 
                                :label="substr($tipo->nombreTipoEncuesta, 0, 1)" 
                                size="md" 
                                class="mr-4 bg-emerald-100 text-emerald-700" 
                            />
                            <div>
                                <p class="text-lg font-medium text-slate-900">
                                    {{ $tipo->nombreTipoEncuesta }}
                                </p>
                                @if($tipo->estado)
                                    <x-badge flat green label="Activo" />
                                @else
                                    <x-badge flat red label="Inactivo" />
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <x-mini-button 
                                rounded 
                                flat 
                                icon="pencil" 
                                title="Editar" 
                                wire:click="edit({{ $tipo->id }})"
                                spinner="edit({{ $tipo->id }})"
                                spinner-target="edit({{ $tipo->id }})"
                            />
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            {{ $tipos->links() }}
        </div>
    </div>
</div>
  