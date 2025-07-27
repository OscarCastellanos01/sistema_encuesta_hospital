@extends('layouts.app')

@section('titulo', 'Encuesta')

@section('contenido')
@livewire('encuesta.respuestas', ['encuesta' => $encuesta], key($encuesta->id))
@endsection
