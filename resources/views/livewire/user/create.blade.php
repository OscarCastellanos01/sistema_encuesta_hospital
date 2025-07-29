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
                </div>

                <div>
                    <x-input
                        label="Correo Electrónico"
                        wire:model.defer="email"
                    />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input
                        label="Contraseña"
                        type="password"
                        wire:model.defer="password"
                    />
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
                </div>
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
