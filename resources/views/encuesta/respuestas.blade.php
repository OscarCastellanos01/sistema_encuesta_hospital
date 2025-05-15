@extends('layouts.app')

@section('titulo', 'Encuenta')

@section('contenido')
@livewire('encuesta.respuestas', ['encuesta' => $encuesta], key($encuesta->id))
@endsection
