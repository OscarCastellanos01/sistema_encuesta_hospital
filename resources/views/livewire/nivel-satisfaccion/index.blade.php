<div class="flex justify-center py-10 px-4">
  <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 
              w-full max-w-[1100px] mx-auto px-10 py-12">

    {{-- Mensajes --}}
    <div class="sticky top-4 z-10 p-4 rounded-xl">
      @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
          {{ session('message') }}
        </div>
      @endif

      {{-- Formulario --}}
      <form 
        wire:submit.prevent="save"
        class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 items-end"
      >  
        <div class="md:col-span-2">
         <x-input
           label="Nivel de Satisfacción"
           placeholder="Escribe el nombre…"
           wire:model.defer="nombreNivelSatisfaccion"
         />
         @error('nombreNivelSatisfaccion')
           <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
         @enderror
        </div>

        <div class="md:col-span-1">
          <label class="block text-sm font-medium mb-1">Emoji</label>
          <select
           wire:model.defer="selectedCodigo"
            class="w-full border rounded px-3 py-2"
          >
            <option value="">Selecciona un nivel…</option>
            @foreach($options as $code => $opt)
              <option value="{{ $code }}">
                {{ $opt['emoji'] }}
              </option>
            @endforeach
          </select>
          @error('selectedCodigo')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex items-center">
          <x-toggle
            label="Estado"
            on-label="Activo"
            off-label="Inactivo"
            wire:model.defer="estadoNivelSatisfaccion"
          />
        </div>

        <div class="md:col-span-4 flex justify-end">
          <x-button
            type="submit"
            primary
            label="{{ $satisfaccionId ? 'Actualizar' : 'Crear' }}"
            spinner="save"
            spinner-target="save"
          />
        </div>
      </form>
    </div>

    {{-- Listado --}}
    <div class="mt-6 overflow-y-auto" style="max-height: 400px;">
      <ul class="divide-y divide-gray-200">
        @forelse($niveles as $nivel)
          <li class="flex items-center justify-between py-4">
            <div class="flex items-center">
              <x-avatar 
                :label="($nivel->emojiSatisfaccion)" 
                size="md" 
                class="mr-4 bg-indigo-100 text-indigo-700" 
              />
              <div>
                <p class="text-lg font-medium text-slate-900">
                  {{ $nivel->nombreNivelSatisfaccion }}
                </p>
                @if($nivel->estadoNivelSatisfaccion)
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
                wire:click="edit({{ $nivel->id }})"
                spinner="edit({{ $nivel->id }})"
                spinner-target="edit({{ $nivel->id }})"
              />
            </div>
          </li>
        @empty
          <li class="text-center text-gray-500 py-4">
            No hay niveles registrados.
          </li>
        @endforelse
      </ul>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
      {{ $niveles->links() }}
    </div>
  </div>
</div>
