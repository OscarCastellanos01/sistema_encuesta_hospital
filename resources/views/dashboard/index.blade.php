@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
    @livewire('dashboard.facilitator-activity')
    @livewire('dashboard.recent-surveys')
    @livewire('dashboard.satisfaction-level-chart')
    @livewire('dashboard.stats-overview')
    @livewire('dashboard.survey-type-distribution')
@endsection
