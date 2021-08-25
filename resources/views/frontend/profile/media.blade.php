@extends('layouts.frontend.profile')
@section('main-content')
    <div class="title small">
        {{ __('custom.profile_media_files') }}
    </div>
    <div class="edit-media-files edit-contacts-info_tabs mt-40">
        <nav>
            <div class="nav tabs-nav" id="nav-tab" role="tablist">
                @foreach($languages as $language)
                    <a class="@if(app()->getLocale() === $language->name) active @endif" id="{{ $language->name }}-tab" data-toggle="tab" href="#{{ $language->name }}" role="tab" aria-controls="{{ $language->name }}" aria-selected="@if(app()->getLocale() === $language->name) true @else false @endif">
                        {{ $language->text }}
                    </a>
                @endforeach
            </div>
        </nav>
        <div class="title small">
            Видеопрезентация (URL YouTube)
        </div>
        <div class="tab-content mt-20" id="nav-tabContent">
            @foreach($languages as $language)
                @php
                    $usersStringsState = false;
                    if ($user->userStrings()->first() !== null && $usersStrings = $user->userStrings()->first()->getUsersString($language->id, $user->id))
                        $usersStringsState = true;

                @endphp
                <div class="tab-pane fade @if(app()->getLocale() === $language->name) show active @endif" id="{{ $language->name }}" role="tabpanel" aria-labelledby="{{ $language->name }}-tab">
                    <form action="{{ route('profile.presentation.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="errors">
                            @if($errors->any())
                                @foreach ($errors->all() as $message)
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-control mt-20">
                            <input type="text" name="url[{{ $language->name }}]" value="@if($usersStringsState) {{ $usersStrings->mediafiles_url['presentation']['url'] }} @endif" placeholder="Введите url на видео">
                        </div>
                        <div class="title small mt-40">
                            Превью для видеопрезентации
                        </div>
                        <div class="previews-video-list">
                            @if(isset($usersStrings->mediafiles_url['presentation']) && !empty($usersStrings->mediafiles_url['presentation']['file_id']))
                                @if($file = $usersStrings->getFileById($usersStrings->mediafiles_url['presentation']['file_id']))
                                    <div class="preview-video">
                                        <div class="preview-video_image">
                                            <img src="{{ asset($file->file_path) }}" alt="">
                                        </div>
                                        <div class="preview-video_cancel" data-id="{{ $file->id }}"></div>
                                    </div>
                                @endif
                            @endif
                            <input id="thumb-input-{{$language->name}}" type="file" name="thumb[{{ $language->name }}]" style="display: none">
                            <div class="add-video thumb-add-{{$language->name}}">
                            </div>
                        </div>
                        <button class="button primary big mt-15">
                            {{ __('custom.form_save') }}
                        </button>
                    </form>
                </div>
            @endforeach
                <form id="upload-media" action="{{ route('profile.media.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="title small mt-40">
                        Медиа Файлы
                    </div>
                    <div class="previews-video-list">
                        @if(!empty($files))
                            @foreach($files as $file)
                                <div class="preview-video">
                                    <div class="preview-video_image">
                                        <img src="{{ asset($file->file_path) }}" alt="">
                                    </div>
                                    <div class="preview-video_cancel" data-id="{{ $file->id }}"></div>
                                </div>
                            @endforeach
                        @endif
                        <input id="file-input" type="file" name="files[]" multiple style="display: none">
                        <div class="add-video file-add">
                        </div>
                    </div>
                    <button class="button primary big mt-15">
                        {{ __('custom.form_save') }}
                    </button>
                </form>
        </div>
    </div>
@endsection
@section('footer-scripts')
    <script>
        $(".file-add").on('click', function () {
            $("#file-input").click();
        });

        $("#file-input").change(function() {
            let files = this.files;
            handleFileSelect(files, 'file-add');
        });

        @foreach($languages as $language)
            $(".thumb-add-{{$language->name}}").on('click', function () {
                $("#thumb-input-{{$language->name}}").click();
            });

            $("#thumb-input-{{$language->name}}").change(function() {
                let files = this.files;
                handleFileSelect(files, 'thumb-add-{{$language->name}}');
            });
        @endforeach

        $("#upload-media").on('submit', function (e) {
            e.preventDefault();

            let Data = new FormData();
            let files = document.getElementById('file-input').files;
            $(files).each(function(index, file) {
                Data.append('files[]', file);
            });

            let token = $('form').find('input[name="_token"]').val();
            Data.append('_token', token);

            ajax($(this).attr('action'), $(this).attr('method'), Data);
        });

        $('.preview-video_cancel').on('click', function () {
            let id = $(this).attr('data-id');
            let data = new FormData();
            if (id !== "") {
                data.append('id', id);
                data.append('_token', "{{ csrf_token() }}");
                ajax("{{ route('profile.media.delete') }}", "POST", data);
            }
        });

        function ajax(action, method, data) {

            $.ajax({
                url: action,
                type: method,
                data: data,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (!data.answer) toastr.error("Ошибка при загрузке");
                    else toastr.success("{{ __('custom.success') }}");
                    setTimeout(function() {
                        document.location.reload()
                    }, 5000);
                },
                error: function(data) {
                    let errors = data.responseJSON;

                    let errorsHtml = '<div class="alert alert-danger"><ul>';
                    if (typeof errors.errors !== 'undefined') {
                        $.each(errors.errors, function (key, value) {
                            for (let i = 0; i < value.length; i++)
                                errorsHtml += '<li>' + value[i] + '</li>';
                        });
                        errorsHtml += '</ul></div>';
                        $('#errors').html(errorsHtml);
                    }
                    toastr.error("Ошибка при загрузке");
                }
            });
        }

        function handleFileSelect(files, className) {
            for (let i = 0; i < files.length; i++) {
                if (!files[i].type.match('image.*')) {
                   toastr.error("Загрузите изображение");
                }
                let reader = new FileReader();

                reader.onload = (function (theFile) {
                    return function (e) {
                        $('<div class="preview-video red"><div class="preview-video_image"><img src="'+ e.target.result +'" alt=""></div><div class="preview-video_cancel"></div></div>').insertBefore('.'+className);
                        switch (className) {
                            case 'thumb-add-ru':
                            case 'thumb-add-en':
                            case 'thumb-add-kz':
                                $('.'+className).css('display', 'none');
                        }
                    };
                })(files[i]);

                reader.readAsDataURL(files[i]);
            }
        }

    </script>
@endsection
