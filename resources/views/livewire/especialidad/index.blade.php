<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12">

    {{-- Mensaje flash --}}
    <div class="sticky top-4 z-10 p-4 rounded-xl">
      @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
          {{ session('message') }}
        </div>
      @endif

      {{-- Formulario --}}
      <form 
        wire:submit.prevent="save"
        class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 items-end"
      >
        {{-- Nombre --}}
        <div class="md:col-span-3">
          <x-input
            label="Especialidad"
            placeholder="Escribe el nombre…"
            wire:model.defer="nombreEspecialidad"
          />
        </div>

        {{-- Estado --}}
        <div class="flex items-center">
          <x-toggle
            label="Estado"
            on-label="Activo"
            off-label="Inactivo"
            wire:model.defer="estadoEspecialidad"
          />
        </div>

        {{-- Botón --}}
        <div class="md:col-span-4 flex justify-end">
          <x-button
            type="submit"
            primary
            label="{{ $especialidadId ? 'Actualizar' : 'Crear' }}"
            spinner="save"
            spinner-target="save"
          />
        </div>
      </form>
    </div>

    {{-- Listado --}}
    <div class="mt-6 overflow-y-auto" style="max-height: 400px;">
      <ul class="divide-y divide-gray-200">
        @forelse($items as $item)
          <li class="flex items-center justify-between py-4">
            <div class="flex items-center">
              <x-avatar 
                :label="substr($item->nombreEspecialidad, 0, 1)" 
                size="md" 
                class="mr-4 bg-pink-100 text-pink-700" 
              />
              <div>
                <p class="text-lg font-medium text-slate-900">
                  {{ $item->nombreEspecialidad }}
                </p>
                @if($item->estadoEspecialidad)
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
                wire:click="edit({{ $item->id }})"
                spinner="edit({{ $item->id }})"
                spinner-target="edit({{ $item->id }})"
              />
            </div>
          </li>
        @empty
          <li class="text-center text-gray-500 py-4">
            No hay especialidades registradas.
          </li>
        @endforelse
      </ul>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
      {{ $items->links() }}
    </div>
  </div>
</div>
