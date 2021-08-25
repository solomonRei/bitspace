@extends('layouts.frontend.profile')
@section('header-script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
@endsection
@section('main-content')
    <div class="title small">
        {{ __('custom.profile_settings') }}
    </div>

    <form action="{{ route('profile.update') }}" id="editSettings" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-control_group mt-45">
            <div class="form-control">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="form-input_email">
                    Изменить Аватарку
                </label>

            </div>
            <div class="form-control">
                <div class="profile_image">
                    @if(isset(auth()->user()->ava) && @$file = auth()->user()->getFileById(auth()->user()->ava))
                        <img src="{{ asset($file->file_path) }}" alt="">
                    @else
                        <img src="{{ asset(config('app.default_ava')) }}" alt="">
                    @endif
                </div>
                <input id="file-input" type="file" name="ava" style="display: none">
                            <div class="mt-10 button button-to-change file-add">
                                @lang('custom.form_edit')
                            </div>
            </div>
        </div>
        <div class="form-control_group mt-45">
            <div class="form-control">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="form-input_email">
                    @lang('custom.form_edit') e-mail @lang('custom.form_address')
                </label>
            </div>
            <div class="form-control">
                <input type="text" id="form-input_email" name="email" placeholder="e-mail" value="{{ $user->email }}">
                {{--            <div class="mt-10 button button-to-change">--}}
                {{--                @lang('custom.form_edit')--}}
                {{--            </div>--}}
            </div>
        </div>
        <div class="form-control_group mt-40">
            <div class="form-control">
                <div class="info-label">
                    @lang('custom.form_edit') @lang('custom.form_password_from_profile')
                </div>
            </div>
            <div class="form-control">
                <div class="link with-arrow">
										<span>
											@lang('custom.form_changing_password')
										</span>
                </div>
            </div>
        </div>
        <div class="border-line"></div>
{{--        <div class="title small mt-30">--}}
{{--            @lang('custom.form_2fa')--}}
{{--        </div>--}}
{{--        <div class="form-control_group mt-45">--}}
{{--            <div class="form-control">--}}
{{--                <label for="form-input_phone">--}}
{{--                    Введите номер телефона--}}
{{--                </label>--}}
{{--                <div class="info-text">--}}
{{--                    При авторизации на этот номер будет приходить код для подтверждения--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="form-control">--}}
{{--                @error('phone')--}}
{{--                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                @enderror--}}
{{--                <input type="text" id="form-input_phone" name="phone" placeholder="Номер телефона"--}}
{{--                       value="{{ $user->phone }}" @if($user->fa2) disabled @endif>--}}
{{--                @if(!$user->fa2)--}}
{{--                    <div class="mt-20 button dark-outline big fa2">--}}
{{--                        Подключить--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="border-line"></div>

        <div class="form-control checkoxes">
            @error('is_hided')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="hidden" value="@if($user->is_hided) on @else off @endif" name="is_hided">
            <input class="styled-checkbox" id="hide-profile" name="is_hided" type="checkbox"
                   @if($user->is_hided) checked @endif>
            <label for="hide-profile">
                Скрыть публичный профиль
            </label>
        </div>
        <div class="form-control checkoxes mt-20">
            @error('is_searched')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="hidden" value="@if($user->is_searched) on @else off @endif" name="is_searched">
            <input class="styled-checkbox" id="hide-search-profile" name="is_searched" type="checkbox"
                   @if($user->is_searched) checked @endif>
            <label for="ide-search-profile">
                Убрать профиль из поиска на сайте
            </label>
        </div>
        <div class="form-control checkoxes mt-20">
            <a href="{{ route('profile.delete') }}" class="link-to-delete-profile">
                <span>Удалить профиль</span>
            </a>
        </div>
        <button type="submit" class="button save primary mt-50">
            Сохранить
        </button>
    </form>
@endsection
@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    <script>
        $("#hide-profile").on('click', function () {
            if ($(this).prop('checked')) {
                $("input[name='is_hided']").val('on');
                $(this).attr('checked', true);
            } else {
                $("input[name='is_hided']").val('off');
                $(this).attr('checked', false);
            }
        });

        $("#hide-search-profile").on('click', function () {
            if ($(this).prop('checked')) {
                $("input[name='is_searched']").val('on');
                $(this).attr('checked', true);
            } else {
                $("input[name='is_searched']").val('off');
                $(this).attr('checked', false);
            }
        });

        $('.fa2').on('click', function () {
            location.href = "{{ route('profile.2fa') }}";
        });

        $(".file-add").on('click', function () {
            $("#file-input").click();
        });

    </script>
@endsection

