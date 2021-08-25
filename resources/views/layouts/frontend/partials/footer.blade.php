<div class="container">
    <div class="footer_container">
        <div class="logo">
            <img src="/img/logo.png" alt="">
        </div>
        <div class="footer_main-info">
            <div class="footer_main-info_top d-none d-md-flex">
                <menu class="footer_menu">
                   @include('layouts.frontend.partials.menu')
                </menu>
                <ul class="footer_languages">
                    @include('layouts.frontend.partials.languages')
                </ul>
                @guest
                    <a href="#" class="button button-login light">
                        <span>{{ __('Login') }}</span>
                    </a>
                @endguest
            </div>
            <div class="footer_main-info_bottom">
                <div class="footer_copyrights">
                    <span>BS Specialist © 2020 </span><br>
                    {{ __('custom.footer_rights') }}
                </div>
                <div class="footer_support">
                    {{ __('custom.footer_support') }} <br>
                    <a href="mailto: help@bsspec.ru">
                        help@bsspec.ru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
