<div class="flex justify-center py-10 px-4">
  <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 
              w-full max-w-[1100px] mx-auto px-10 py-12">

    {{-- Mensajes de éxito/error --}}
    <div class="sticky top-4 z-10 p-4 rounded-xl">
      @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
          {{ session('message') }}
        </div>
      @endif

      {{-- Formulario inline --}}
      <form 
        wire:submit.prevent="{{ $area_id ? 'update' : 'store' }}"
        class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 items-end"
      >
        {{-- Nombre de Área --}}
        <div class="md:col-span-3">
          <x-input
            label="Área"
            placeholder="Escribe el nombre…"
            wire:model.defer="nombreArea"
          />
        </div>

        {{-- Toggle Estado --}}
        <div class="flex items-center">
          <x-toggle
            label="Estado"
            on-label="Activo"
            off-label="Inactivo"
            wire:model.defer="estado"
          />
        </div>

        {{-- Botón Crear/Actualizar --}}
        <div class="md:col-span-4 flex justify-end">
          <x-button
            type="submit"
            primary
            label="{{ $area_id ? 'Actualizar' : 'Crear' }}"
            spinner="{{ $area_id ? 'update' : 'store' }}"
            spinner-target="{{ $area_id ? 'update' : 'store' }}"
          />
        </div>
      </form>
    </div>

    {{-- Listado con scroll --}}
    <div class="mt-6 overflow-y-auto" style="max-height: 400px;">
      <ul class="divide-y divide-gray-200">
        @forelse($areas as $area)
          <li class="flex items-center justify-between py-4">
            <div class="flex items-center">
              {{-- Avatar con inicial --}}
              <x-avatar 
                :label="substr($area->nombreArea, 0, 1)" 
                size="md" 
                class="mr-4 bg-blue-100 text-blue-700" 
              />
              <div>
                <p class="text-lg font-medium text-slate-900">
                  {{ $area->nombreArea }}
                </p>
                @if($area->estado)
                  <x-badge flat green label="Activo" />
                @else
                  <x-badge flat red label="Inactivo" />
                @endif
              </div>
            </div>
            <div class="flex space-x-2">
              {{-- Editar --}}
              <x-mini-button 
                rounded 
                flat 
                icon="pencil" 
                title="Editar" 
                wire:click="edit({{ $area->id }})"
                spinner="edit({{ $area->id }})"
                spinner-target="edit({{ $area->id }})"
              />
            </div>
          </li>
        @empty
          <li class="text-center text-gray-500 py-4">
            No hay áreas registradas.
          </li>
        @endforelse
      </ul>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
      {{ $areas->links() }}
    </div>
  </div>
</div>
