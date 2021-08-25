@extends('layouts.frontend.profile')
@section('main-content')
    <div class="title small center-sm">
        {{ __('custom.profile_contact_information') }}
    </div>
    <div class="edit-contacts-info_tabs">
        <nav>
            <div class="nav tabs-nav" id="nav-tab" role="tablist">
                @foreach($languages as $language)
                <a class="@if(app()->getLocale() === $language->name) active @endif" id="{{ $language->name }}-tab" data-toggle="tab" href="#{{ $language->name }}" role="tab" aria-controls="{{ $language->name }}" aria-selected="@if(app()->getLocale() === $language->name) true @else false @endif">
                    {{ $language->text }}
                </a>
                @endforeach
            </div>
        </nav>

        <div class="tab-content mt-20" id="nav-tabContent">
            @foreach($languages as $language)
                @php
                    $usersStringsState = false;
                    if ($user->userStrings()->first() !== null && $usersStrings = $user->userStrings()->first()->getUsersString($language->id, $user->id))
                        $usersStringsState = true;
                @endphp
                <div class="tab-pane fade @if(app()->getLocale() === $language->name) show active @endif" id="{{ $language->name }}" role="tabpanel" aria-labelledby="{{ $language->name }}-tab">
                <form action="{{ route('profile.contacts.update') }}" method="POST">
                    @csrf
                    <div class="form-control_group">
                        <div class="form-control">
                            <label class="light-label" for="form-input_name">
                                Ваше имя
                            </label>
                            <input type="text" id="form-input_name" name="name[{{ $language->name }}]" @if($usersStringsState) value="{{ $usersStrings->name }}" @endif placeholder="Ваше имя">
                        </div>
                        <div class="form-control">
                            <label for="form-input_firstname">
                                Ваше фамилия
                            </label>
                            <input type="text" id="form-input_firstname" name="surname[{{ $language->name }}]" @if($usersStringsState) value="{{ $usersStrings->surname }}" @endif placeholder="Ваша фамилия">
                        </div>
                    </div>
                    <div class="form-control_group">
                        <div class="form-control">
                            <input type="text" name="education[{{ $language->name }}]" @if($usersStringsState) value="{{ $usersStrings->education }}" @endif placeholder="Несколько слов о вашем образовании">
                        </div>
                        <div class="form-control">
                            <input type="text" placeholder="Номер телефона">
                        </div>
                        <div class="form-control">
                            <input type="text" placeholder="Город">
                        </div>
                    </div>
                    <button class="button primary w-100 mt-20">
                        {{ __('custom.form_save') }}
                    </button>
                </form>
                <div class="link-accoun-to-bs mt-40 mt-md-30">
                    <div class="link-accoun-to-bs_info">
                        Привязать аккаунт BitSpace
                    </div>
                    <div class="button dark-outline">
                        Привязать
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection

