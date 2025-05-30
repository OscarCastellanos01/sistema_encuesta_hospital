@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
    @livewire('dashboard.satisfaction-level-chart')
    @livewire('dashboard.stats-overview')
    @livewire('dashboard.survey-type-distribution')
    @livewire('dashboard.facilitator-activity')
    @livewire('dashboard.recent-surveys')
@endsection
