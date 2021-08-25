@extends('layouts.frontend.profile')
@section('main-content')
    <div class="title small center-sm">
        {{ __('custom.my_profile') }}
    </div>
    <div class="services-list row">
        <div class="col-12 col-sm-6 col-lg-12 col-xl-6 item">
            <div class="item_container" style="background: #D9FFBB">
                <div class="item_image">
                    <img src="/images/pages/account/img-1.svg" alt="">
                </div>
                <div class="item_title">
                    Разместить профиль <br>
                    в каталоге
                </div>
                <div class="item_add-info">
                    5 000 тенге <span>/ пожизненно</span>
                </div>
                <a href="#" class="button dark-outline">
                    Подключить
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-12 col-xl-6 item">
            <div class="item_container" style="background: #9DE9FF">
                <div class="item_image">
                    <img src="/images/pages/account/top.svg" alt="">
                </div>
                <div class="item_title">
                    Поднять профиль в ТОП <br>
                    сайта
                </div>
                <div class="item_add-info">
                    500 тенге <span>/ пожизненно</span>
                </div>
                <a href="#" class="button dark-outline">
                    Подключить
                </a>
            </div>
        </div>
        <div class="col-12 item two-columns">
            <div class="item_container" style="background: rgba(112, 255, 195, 0.5);">
                <div class="item_image">
                    <img src="/images/pages/account/all.svg" alt="">
                </div>
                <div class="item_info">
                    <div class="item_title">
                        Тариф “Все включено”
                    </div>
                    <div class="item_add-info">
                        <span>Активировано до 20.01.2020</span>
                    </div>
                    <a href="#" class="button dark-outline">
                        Подключить
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

