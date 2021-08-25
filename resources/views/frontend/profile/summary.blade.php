@extends('layouts.frontend.profile')
@section('main-content')
    <div class="title small center-sm">
        {{ __('custom.profile_summary') }}
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
                <form action="{{ route('profile.summary.update') }}" method="POST">
                    @csrf
                    <div class="form-control">
                        <textarea name="about[{{ $language->name }}]" placeholder="Введите текст">@if($usersStringsState) {{ $usersStrings->about }} @endif</textarea>
                    </div>
                    <button class="button primary big mt-15">
                        {{ __('custom.form_save') }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
@endsection
