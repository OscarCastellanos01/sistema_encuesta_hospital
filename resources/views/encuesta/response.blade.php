@extends('layouts.app')

@section('titulo', 'Encuesta')

@section('contenido')
    @livewire('encuesta.view', ['encuesta' => $encuesta], key($encuesta->id))
@endsection
