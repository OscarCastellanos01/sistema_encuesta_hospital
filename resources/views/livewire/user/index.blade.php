<div class="space-y-4">
    <x-input label="Nombre" wire:model.defer="name" />
    <x-input label="Email" wire:model.defer="email" />
    <x-input label="Contraseña" type="password" wire:model.defer="password" />

    <x-select label="Rol" wire:model.defer="id_rol">
        <option value="">Seleccione un rol</option>
        @foreach($roles as $rol)
            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
        @endforeach
    </x-select>

    <x-select label="Estado" wire:model.defer="estado_usuario">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </x-select>

    <x-button wire:click="save" primary>
        {{ $userId ? 'Actualizar' : 'Crear' }} Usuario
    </x-button>

    @if (session('success'))
        <x-alert variant="success">{{ session('success') }}</x-alert>
    @endif
</div>
