{{-- resources/views/area/_form.blade.php --}}
<div class="mb-4">
  <label class="block mb-1">Nombre Área</label>
  <input type="text" name="nombreArea"
         value="{{ old('nombreArea', $area->nombreArea ?? '') }}"
         class="w-full border rounded px-3 py-2">
  @error('nombreArea')
    <p class="text-red-600 text-sm">{{ $message }}</p>
  @enderror
</div>

<div class="mb-4">
  <label class="inline-flex items-center">
    <input type="checkbox" name="estado"
           {{ old('estado', $area->estado ?? true) ? 'checked' : '' }}
           class="form-checkbox">
    <span class="ml-2">Activo</span>
  </label>
</div>
