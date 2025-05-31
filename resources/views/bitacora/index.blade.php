@extends('layouts.app')

@section('titulo','Bitácora')

@section('contenido')
  @livewire('bitacora.index')
  @livewire('bitacora.show')
@endsection