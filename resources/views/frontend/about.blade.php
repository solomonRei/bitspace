@extends('layouts.frontend.app')
@section('content')
    <div class="about-us-block">
        <div class="container">
            <div class="title medium">
                {{ __('custom.menu_about') }}
            </div>
            <div class="mt-20" id="breadcrumbs">
                <ul>
                    <li>
                        <a href="/">
                            Главная
                        </a>
                    </li>
                    <li>
                        {{ __('custom.menu_about') }}
                    </li>
                </ul>
            </div>
            <div class="mt-10">
                <div class="article-image">
                    <img src="images/pages/articles/article.jpg" alt="">
                </div>
                <div class="info">
                    <div class="title small">
                        Bitspace это
                    </div>
                    <div class="text mt-30">
                        {{ $data->text }}
                    </div>
                    <div class="contacts">
                        <a href="tel: {{ $data->phone }}" class="contact-phone">
                            <span>Телефон: {{ $data->phone }} </span>
                        </a>
                        <div class="contact-address">
									<span>
										Адресс: {{ $data->address }}
									</span>
                        </div>
                        @if(!empty($data->link))
                            <div class="contact-map">
                                <iframe src="{{ $data->link }}" width="100%" height="100%" frameborder="0"></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
