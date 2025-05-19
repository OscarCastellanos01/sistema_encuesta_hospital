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

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input
                        label="Contraseña"
                        type="password"
                        wire:model.defer="password"
                    />
                    @error('password')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-select
                        label="Rol"
                        placeholder="Selecciona un rol"
                        wire:model.defer="id_rol"
                    >
                        @foreach($roles as $rol)
                            <x-select.option
                                value="{{ $rol->id }}"
                                label="{{ $rol->nombre }}"
                            />
                        @endforeach
                    </x-select>
                    @error('id_rol')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-1">
                <x-select
                    label="Estado"
                    wire:model.defer="estado_usuario"
                >
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </x-select>
                @error('estado_usuario')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <x-button
                    primary
                    label="Crear Usuario"
                    type="submit"
                    spinner="save"
                    wire:loading.attr="disabled"
                />
            </div>
        </form>
    </div>
</div>
