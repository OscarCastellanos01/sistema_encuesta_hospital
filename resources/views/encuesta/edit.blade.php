@extends('layouts.app')

@section('titulo', 'Editar Encuesta')

@section('contenido')
    @livewire('encuesta.edit', ['encuesta' => $encuesta], key($encuesta->id))
@endsection
