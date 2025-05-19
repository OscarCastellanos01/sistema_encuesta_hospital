@extends('layouts.app')

@section('title', 'Usuarios')

@section('contenido')
    @livewire('user.edit', ['user' => $user])
@endsection
