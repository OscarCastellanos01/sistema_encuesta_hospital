@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
    <div class="grid grid-cols-1 md:grid-cols-2">
        @livewire('dashboard.satisfaction-level-chart')
        @livewire('dashboard.stats-overview')
        {{-- @livewire('dashboard.survey-type-distribution') --}}
        @livewire('dashboard.facilitator-activity')
        @livewire('dashboard.recent-surveys')
    </div>
@endsection
