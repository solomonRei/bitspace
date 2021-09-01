@extends('layouts.frontend.app')
@section('content')
    @livewire('profile-filter',[
        'categoryCurrent' => $categoryCurrent,
        'citiesList' => $cities,
        'groupsList' => $groups
    ])
@endsection
@section('footer-scripts')
    @livewireScripts
    @stack('scripts')
@endsection
