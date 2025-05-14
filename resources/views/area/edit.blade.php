@extends('layouts.app')

@section('titulo', 'Editar Área')

@section('contenido')
<div class="p-6 bg-white rounded-lg shadow">
  <h2 class="text-xl font-semibold mb-4">Editar Área</h2>

  <form action="{{ route('area.update', $area) }}" method="POST">
    @csrf @method('PUT')

    @include('area._form')

    <div class="mt-6 flex space-x-3">
      <button type="submit"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 
                     text-white font-medium rounded shadow">
        Actualizar
      </button>
      <a href="{{ route('area.index') }}"
         class="px-4 py-2 bg-gray-300 hover:bg-gray-400 
                text-gray-800 font-medium rounded shadow">
        Cancelar
      </a>
    </div>
  </form>
</div>
@endsection
