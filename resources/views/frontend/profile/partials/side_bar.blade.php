<ul class="sidebar_links">
    @if(in_array(auth()->user()->type, [0,3]))
    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('profile.index') }}">
										<span class="icon">
											<img src="/img/icons/account/my-office.svg" alt="">
										</span>
            <span class="title">
											{{ __('custom.my_profile') }}
										</span>
        </a>
    </li>
    @endif
    <li class="{{ Request::is('dashboard/contact-information') ? 'active' : '' }}">
        <a href="{{ route('profile.contacts.show') }}">
										<span class="icon">
											<img src="/img/icons/account/contacts-info.svg" alt="">
										</span>
            <span class="title">
											{{ __('custom.profile_contact_information') }}
										</span>
        </a>
    </li>
        <li class="{{ Request::is('dashboard/events') ? 'active' : '' }}">
            <a href="{{ route('profile.events.show') }}">
										<span class="icon">
											<img src="/img/icons/account/carts.svg" alt="">
										</span>
                <span class="title">
											{{ __('custom.profile_events') }}
										</span>
            </a>
        </li>
    <li class="{{ Request::is('dashboard/full-calender') ? 'active' : '' }}">
        <a href="{{ route('profile.calendar.show') }}">
										<span class="icon">
											<img src="/img/icons/account/parameters.svg" alt="">
										</span>
            <span class="title">
											{{ __('custom.profile_parameters') }}
										</span>
        </a>
    </li>
        @if(in_array(auth()->user()->type, [0,3]))
            <li class="{{ Request::is('dashboard/summary') ? 'active' : '' }}">
                <a href="{{ route('profile.summary.show') }}">
                                                <span class="icon">
                                                    <img src="/img/icons/account/cv.svg" alt="">
                                                </span>
                    <span class="title">
                                                    {{ __('custom.profile_summary') }}
                                                </span>
                </a>
            </li>

            <li class="{{ Request::is('dashboard/media-files') ? 'active' : '' }}">
                <a href="{{ route('profile.media.showUser') }}">
                                                <span class="icon">
                                                    <img src="/img/icons/account/media.svg" alt="">
                                                </span>
                    <span class="title">
                                                    {{ __('custom.profile_media_files') }}
                                                </span>
                </a>
            </li>
            <li class="{{ Request::is('dashboard/reviews') ? 'active' : '' }}">
                <a href="{{ route('profile.reviews.show') }}">
                                                <span class="icon">
                                                    <img src="/img/icons/account/reviews.svg" alt="">
                                                </span>
                    <span class="title">
                                                    {{ __('custom.profile_feedback_management') }}
                                                </span>
                </a>
            </li>
        @endif
{{--    <li>--}}
{{--        <a href="#">--}}
{{--										<span class="icon">--}}
{{--											<img src="/img/icons/account/carts.svg" alt="">--}}
{{--										</span>--}}
{{--            <span class="title">--}}
{{--											{{ __('custom.profile_map_settings') }}--}}
{{--										</span>--}}
{{--        </a>--}}
{{--    </li>--}}
    <li class="{{ Request::is('dashboard/settings') ? 'active' : '' }}">
        <a href="{{ route('profile.settings') }}">
										<span class="icon">
											<img src="/img/icons/account/settings.svg" alt="">
										</span>
            <span class="title">
											{{ __('custom.profile_settings') }}
										</span>
        </a>
    </li>
    <li>
        <a href="{{ route('profile.logout') }}">
										<span class="icon">
											<img src="/img/icons/account/exit.svg" alt="">
										</span>
            <span class="title">
											{{ __('custom.profile_exit') }}
										</span>
        </a>
    </li>
</ul>
