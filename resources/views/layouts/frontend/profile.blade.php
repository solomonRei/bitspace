@extends('layouts.frontend.app')
@section('content')
    <div class="personal-info-block">
        <div class="container">
            <div class="block-container">
                @include('frontend.profile.partials.breadcrumbs')
                <div class="wrapper">
                    <div class="sidebar">
                        @include('frontend.profile.partials.side_bar')
                    </div>
                    <div class="main-content">
                        @yield('main-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
