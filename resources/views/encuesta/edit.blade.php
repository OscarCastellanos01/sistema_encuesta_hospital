@extends('layouts.app')

@section('titulo', 'Editar Encuenta')

@section('contenido')
    @livewire('encuesta.edit', ['encuesta' => $encuesta], key($encuesta->id))
@endsection
