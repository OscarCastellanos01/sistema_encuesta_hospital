@extends('layouts.app')

@section('titulo', 'Encuenta')

@section('contenido')
    @livewire('encuesta.view', ['encuesta' => $encuesta], key($encuesta->id))
@endsection
