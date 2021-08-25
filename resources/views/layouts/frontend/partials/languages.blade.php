@foreach(config('app.languages') as $langLocale => $langName)
    <li @if (app()->getLocale() === $langLocale) class="active" @endif>
        <a href="{{ url()->current() }}?change_language={{ $langLocale }}">
            {{ strtoupper($langLocale) }}
        </a>
    </li>
@endforeach
