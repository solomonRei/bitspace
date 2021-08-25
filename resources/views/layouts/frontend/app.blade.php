<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {!! Meta::toHtml() !!}

    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- jQuery and JS bundle w/ Popper.js -->
    @jquery
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- For profile -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <link rel="stylesheet" href="{{ mix('vendor/css/vendor.css') }}" />

    <script src="{{ mix('js/script.js') }}"></script>

    <script src="{{ mix('vendor/js/vendor.js') }}"></script>

    @toastr_css

    @yield('header-script')

    @yield('header-css')

</head>
<body>
    <header id="header">
        <div class="container">
            <div class="header_container">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="/img/logo.png" alt="">
                    </a>
                </div>
                <menu class="header_menu d-none d-md-flex">
                    @include('layouts.frontend.partials.menu')
                </menu>
                <ul class="header_languages  d-none d-md-flex">
                    @include('layouts.frontend.partials.languages')
                </ul>
                <div class="d-flex align-items-center">
                    @guest
                        <a href="{{ route('login') }}" class="button button-login dark d- d-md-block">
                            <span>{{ __('Login') }}</span>
                        </a>
                    @endguest
                    @auth
                            <a href="{{ route('profile.index') }}" class="button button-to-personal-acctount light">
                                <div class="image">
                                    @if(isset(auth()->user()->ava) && @$file = auth()->user()->getFileById(auth()->user()->ava))
                                        <img src="{{ asset($file->file_path) }}" alt="">
                                    @else
                                        <img src="{{ asset(config('app.default_ava')) }}" alt="">
                                    @endif
                                </div>
                                <div class="title">
                                    {{ $userAuth->name ?? '' }} {{ $userAuth->surname ?? '' }}
                                </div>
                            </a>
                    @endauth
                    <a href="#" class="header-menu-button d-md-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="header-mobile d-md-none" id="header-modile">
            <div class="container">
                <menu class="header_menu">
                    @include('layouts.frontend.partials.menu')
                </menu>
                <ul class="header_languages">
                  @include('layouts.frontend.partials.languages')
                </ul>
            </div>
        </div>
    </header>
    <div id="content" @isset($class) class="{{ $class }}" @endisset>
        @yield('content')
        @if(!in_array(Request::path(), ['ru','en', 'kz']))
            @include('layouts.frontend.partials.questions')
        @endif
    </div>
        @yield('after-content')
    <footer id="footer">
        @yield('footer-scripts')
        @include('layouts.frontend.partials.footer')
    </footer>
    @toastr_js
    @toastr_render
</body>
