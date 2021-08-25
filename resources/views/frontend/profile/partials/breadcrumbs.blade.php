<div id="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('profile.index') }}">
                {{ __('custom.profile_main_lk') }}
            </a>
        </li>
        <li>
            {{ $userAuth->name ?? 'Name' }} {{ $userAuth->surname ?? 'Surname' }}
        </li>
    </ul>
</div>
