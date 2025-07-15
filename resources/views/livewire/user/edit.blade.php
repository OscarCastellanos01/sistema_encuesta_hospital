<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 
                w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">

        {{-- Mensaje de éxito --}}
        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-8">

            {{-- Nombre y Email --}}
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input
                        label="Nombre Completo"
                        wire:model.defer="name"
                    />
                    @error('name')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-input
                        label="Correo Electrónico"
                        wire:model.defer="email"
                    />
                    @error('email')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Contraseña, Rol y Estado --}}
            <div class="grid gap-4 md:grid-cols-3">

                {{-- Nueva contraseña opcional --}}
                <div>
                    <x-input
                        label="Nueva Contraseña (opcional)"
                        type="password"
                        wire:model.defer="password"
                        placeholder="Dejar en blanco para no cambiar"
                    />
                    @error('password')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Select Rol (muestra el actual en el placeholder) --}}
                <div>
                    <x-select
                        label="Rol"
                        wire:model.defer="id_rol"
                        placeholder="Selecciona un rol"
                    >
                        @foreach($roles as $rol)
                            <x-select.option
                                :value="$rol->id"
                                :label="$rol->nombre"
                            />
                        @endforeach
                    </x-select>
                    @error('id_rol')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Select Estado (muestra el actual en el placeholder) --}}
                <div>
                    <x-select
                        label="Estado"
                        wire:model.defer="estado_usuario"
                        placeholder="Selecciona un estado"
                    >
                        <x-select.option :value="1" label="Activo" />
                        <x-select.option :value="0" label="Inactivo" />
                    </x-select>
                    @error('estado_usuario')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Botones --}}
            <div class="flex justify-between items-center">
                <x-button
                    primary
                    label="Actualizar Usuario"
                    type="submit"
                    spinner="save"
                    wire:loading.attr="disabled"
                />
            </div>

        </form>
    </div>
</div>
