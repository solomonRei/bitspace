@extends('layouts.frontend.app')
@section('content')
    <div class="profile-block">
        <div class="container">
            <div class="block-content">
                @foreach($user as $u)
                    <div class="mt-20" id="breadcrumbs">
                        <ul>
                            <li>
                                <a href="#">
                                     {{ $u['category']->name }}
                                </a>
                            </li>
                            <li>
                                @if($u['userStrings']['is_exists'])
                                    {{ $u['userStrings']['data']->name }}  {{ $u['userStrings']['data']->surname }}
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="block-container">
                        <div class="wrapper">
                            <div class="sidebar">
                                <div class="profile_image">
                                    @if(isset($u['user']->ava) && @$ava = $u['user']->getFileById($u['user']->ava))
                                        <img src="{{ asset($ava->file_path) }}" alt="">
                                    @else
                                        <img src="{{ asset(config('app.default_ava')) }}" alt="">
                                    @endif
                                </div>
                                <div class="profile-add-info">
                                    <div class="profile-add-info_top">
                                        <div class="profile-add-info_item">
                                                <span class="icon">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M16.9219 19.538V16.9219H15.1037L13.6975 15.5156H11.7088L9.89062 17.3338V19.3225L11.8101 21.242L16.9219 19.538ZM11.2969 17.9162L12.2912 16.9219H13.115L14.5213 18.3281H15.5156V18.5244L12.1899 19.633L11.2969 18.74V17.9162Z" />
                                                        <path
                                                            d="M12 24C18.6075 24 24 18.6071 24 12C24 5.3925 18.6071 0 12 0C5.39255 0 0 5.39292 0 12C0 18.6075 5.39297 24 12 24ZM22.3825 9.89062C22.5209 10.5725 22.5938 11.2779 22.5938 12C22.5938 12.7221 22.5209 13.4275 22.3825 14.1094H20.6035L18.3281 12.9717V12.2912L19.4461 11.1733L22.0542 9.89062H22.3825ZM1.40625 12C1.40625 7.04883 4.82072 2.88061 9.41841 1.72495L9.98845 4.04597L12.7031 5.40333V7.07812H14.3779L15.3632 9.04866L14.6737 9.73819L11.6856 8.24414L10.1592 11.2969H7.07812V13.6975L8.19314 14.8125L7.64241 15.3632L4.82991 13.957L3.27127 15.5156H2.00667C1.61831 14.415 1.40625 13.2319 1.40625 12ZM3.85373 16.9219L5.10759 15.668L7.92009 17.0743L10.1819 14.8125L8.48438 13.115V12.7031H11.0283L12.3145 10.1309L14.9514 11.4493L17.0743 9.32634L15.2471 5.67188H14.1094V4.53417L11.199 3.07898L10.8048 1.47403C11.1973 1.42978 11.5959 1.40625 12 1.40625C16.6095 1.40625 20.5402 4.36589 21.9933 8.48438H21.7271L18.6165 10.0142L16.9219 11.7088V13.8408L20.2715 15.5152L21.9933 15.5156C20.5402 19.6341 16.6095 22.5938 12 22.5938C7.9343 22.5938 4.39683 20.2912 2.62144 16.9219H3.85373Z" />
                                                    </svg>
                                                </span>
                                            <span class="title">
                                                   {{ __('custom.profile_public_city') }} {{ !empty($u['city']) ? $u['city']->name : '' }}
                                                </span>
                                        </div>
                                        <div class="profile-add-info_item">
                                                <span class="icon">
                                                    <svg width="24" height="22" viewBox="0 0 24 22" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M23.3013 3.26581C23.2998 3.26581 23.2983 3.26562 23.2969 3.26562H16.9219V2.5625C16.9219 1.39941 15.9756 0.453125 14.8125 0.453125H9.1875C8.02441 0.453125 7.07812 1.39941 7.07812 2.5625V3.26562H0.703125C0.311646 3.26562 0 3.58643 0 3.96875V19.4375C0 20.6006 0.946289 21.5469 2.10938 21.5469H21.8906C23.0537 21.5469 24 20.6006 24 19.4375V3.98358C24 3.98267 24 3.98175 24 3.98083C23.9731 3.51904 23.6891 3.26837 23.3013 3.26581ZM8.48438 2.5625C8.48438 2.17487 8.79987 1.85938 9.1875 1.85938H14.8125C15.2001 1.85938 15.5156 2.17487 15.5156 2.5625V3.26562H8.48438V2.5625ZM22.3213 4.67188L20.1378 11.2223C20.042 11.5099 19.7739 11.7031 19.4709 11.7031H15.5156V11C15.5156 10.6116 15.2009 10.2969 14.8125 10.2969H9.1875C8.79913 10.2969 8.48438 10.6116 8.48438 11V11.7031H4.52911C4.22607 11.7031 3.95801 11.5099 3.86224 11.2223L1.67871 4.67188H22.3213ZM14.1094 11.7031V13.1094H9.89062V11.7031H14.1094ZM22.5938 19.4375C22.5938 19.8251 22.2783 20.1406 21.8906 20.1406H2.10938C1.72174 20.1406 1.40625 19.8251 1.40625 19.4375V8.30157L2.52814 11.6671C2.81561 12.5298 3.61981 13.1094 4.52911 13.1094H8.48438V13.8125C8.48438 14.2009 8.79913 14.5156 9.1875 14.5156H14.8125C15.2009 14.5156 15.5156 14.2009 15.5156 13.8125V13.1094H19.4709C20.3802 13.1094 21.1844 12.5298 21.4719 11.6671L22.5938 8.30157V19.4375Z" />
                                                    </svg>
                                                </span>
                                                <span class="title">
                                                    {{ __('custom.profile_public_experience') }} {{ $u['userStrings']['data']->experience ?: '' }}
                                                </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('profile.calendar.show', ['action' => 'plan', 'id' => $u['user']->id ]) }}" class="link-to-bs" target="_blank">
                                        <span>Запланировать</span>
                                    </a>
                                    <a href="https://www.bitspace.kz/" class="link-to-bs" target="_blank">
                                        <span>BitSpace</span>
                                    </a>
                                </div>
                            </div>
                            <div class="main-content">
                                <div class="section table-section">
                                    <div class="title medium center-sm">
                                        Основная информация
                                    </div>
                                    <div class="items_list mt-35">

                                        <div class="item">
                                            <div class="item_left">
                                                    <span class="icon">
                                                        <svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0)">
                                                                <path
                                                                    d="M14.9232 14.8879C14.9526 14.8879 14.9819 14.8879 15.0171 14.8879C15.0289 14.8879 15.0406 14.8879 15.0523 14.8879C15.07 14.8879 15.0934 14.8879 15.111 14.8879C16.8309 14.8593 18.2221 14.2699 19.2494 13.1427C21.5093 10.6595 21.1336 6.40258 21.0926 5.99634C20.9458 2.94668 19.4666 1.48764 18.2456 0.80676C17.3358 0.297529 16.2733 0.0228868 15.0876 0H15.0465C15.0406 0 15.0289 0 15.023 0H14.9878C14.3362 0 13.0566 0.102991 11.8297 0.783873C10.597 1.46476 9.09432 2.92379 8.94757 5.99634C8.90648 6.40258 8.53081 10.6595 10.7907 13.1427C11.8121 14.2699 13.2033 14.8593 14.9232 14.8879ZM10.5149 6.13939C10.5149 6.12222 10.5207 6.10506 10.5207 6.09361C10.7144 1.99115 13.7023 1.55058 14.9819 1.55058H15.0054C15.0171 1.55058 15.0347 1.55058 15.0523 1.55058C16.6372 1.58491 19.3316 2.2143 19.5135 6.09361C19.5135 6.11078 19.5135 6.12794 19.5194 6.13939C19.5253 6.17944 19.9362 10.0702 18.0695 12.1186C17.3299 12.931 16.3437 13.3316 15.0465 13.343C15.0347 13.343 15.0289 13.343 15.0171 13.343C15.0054 13.343 14.9995 13.343 14.9878 13.343C13.6964 13.3316 12.7044 12.931 11.9706 12.1186C10.1098 10.0816 10.509 6.17372 10.5149 6.13939Z"
                                                                    fill="#01B5E8" />
                                                                <path
                                                                    d="M27.0799 21.9483C27.0799 21.9426 27.0799 21.9368 27.0799 21.9311C27.0799 21.8853 27.074 21.8396 27.074 21.7881C27.0388 20.6552 26.9625 18.006 24.4149 17.1592C24.3973 17.1535 24.3739 17.1478 24.3563 17.1421C21.7089 16.4841 19.5077 14.9964 19.4842 14.9792C19.1261 14.7332 18.633 14.819 18.3806 15.1681C18.1282 15.5171 18.2163 15.9977 18.5743 16.2437C18.6741 16.3124 21.0104 17.8973 23.9336 18.6297C25.3013 19.1046 25.4539 20.5293 25.495 21.8339C25.495 21.8853 25.495 21.9311 25.5009 21.9769C25.5068 22.4919 25.4715 23.2872 25.3776 23.7449C24.4267 24.2713 20.6993 26.0908 15.0289 26.0908C9.38195 26.0908 5.63103 24.2656 4.67423 23.7392C4.58031 23.2814 4.53922 22.4861 4.55096 21.9712C4.55096 21.9254 4.55683 21.8796 4.55683 21.8281C4.59792 20.5236 4.75054 19.0989 6.11824 18.624C9.04149 17.8916 11.3777 16.301 11.4775 16.238C11.8356 15.992 11.9236 15.5114 11.6712 15.1623C11.4188 14.8133 10.9257 14.7275 10.5677 14.9735C10.5442 14.9907 8.3547 16.4783 5.6956 17.1363C5.67212 17.1421 5.65451 17.1478 5.6369 17.1535C3.08933 18.006 3.01302 20.6552 2.9778 21.7824C2.9778 21.8339 2.9778 21.8796 2.97193 21.9254C2.97193 21.9311 2.97193 21.9368 2.97193 21.9426C2.96606 22.2401 2.96019 23.7678 3.2713 24.5345C3.33 24.6833 3.43566 24.8091 3.57654 24.895C3.75264 25.0094 7.97315 27.6299 15.0347 27.6299C22.0963 27.6299 26.3168 25.0037 26.4929 24.895C26.6279 24.8091 26.7395 24.6833 26.7982 24.5345C27.0917 23.7735 27.0858 22.2458 27.0799 21.9483Z"
                                                                    fill="#01B5E8" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0">
                                                                    <rect width="28.3461" height="27.6301" fill="white" transform="translate(0.852905)" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg>

                                                    </span>
                                                <span class="title">
                                                        Возраст:
                                                    </span>
                                            </div>
                                            <div class="item_right">
                                                {{ $u['userStrings']['data']->age ?: '' }} {{ $u['userStrings']['data']->age_name }}
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="item_left">
                                                    <span class="icon">
                                                        <svg width="30" height="26" viewBox="0 0 30 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M27.5381 18.9522V7.61952L28.6591 7.20602C28.9838 7.0862 29.199 6.77984 29.199 6.4375C29.199 6.09516 28.9838 5.7888 28.6591 5.66903L15.3165 0.747156C15.1292 0.678031 14.9228 0.678031 14.7355 0.747156L1.39287 5.66903C1.06816 5.7888 0.852905 6.09516 0.852905 6.4375C0.852905 6.77984 1.06816 7.0862 1.39281 7.20597L6.92185 9.24554C5.61289 12.8938 5.94314 14.8129 5.89098 15.4609C5.89098 15.7331 6.02767 15.9876 6.25583 16.1402C6.48404 16.2928 6.77392 16.3236 7.02981 16.2226C7.04913 16.215 8.97943 15.4609 10.8737 15.4609C12.626 15.4609 14.4896 16.908 14.5071 16.9218C14.8105 17.1614 15.2414 17.1614 15.5447 16.9218C16.0589 16.5155 17.7141 15.4609 19.1782 15.4609C21.062 15.4609 23.0034 16.2152 23.0221 16.2226C23.2779 16.3236 23.5679 16.2928 23.796 16.1402C24.0242 15.9876 24.1609 15.7331 24.1609 15.4609C24.1127 14.8621 24.4322 12.8747 23.13 9.24554L25.8772 8.23218V18.9522C25.4502 19.1801 25.0778 19.5889 24.7904 20.1567C24.4202 20.8881 24.2163 21.8424 24.2163 22.8438V24.4844C24.2163 24.9374 24.5881 25.3047 25.0467 25.3047H28.3686C28.8272 25.3047 29.199 24.9374 29.199 24.4844V22.8438C29.199 21.8424 28.9951 20.8881 28.6249 20.1567C28.3375 19.5889 27.9651 19.1801 27.5381 18.9522ZM15.026 2.39128L25.9948 6.4375C24.8632 6.85493 16.121 10.0798 15.026 10.4837C13.9309 10.0798 5.1887 6.85493 4.05712 6.4375L15.026 2.39128ZM22.4932 14.3247C21.6416 14.0855 20.418 13.8203 19.1782 13.8203C17.4795 13.8203 15.8358 14.74 15.026 15.2728C14.2162 14.74 12.5724 13.8203 10.8737 13.8203C9.634 13.8203 8.41035 14.0855 7.5587 14.3247C7.60648 12.6569 7.90632 11.4148 8.4779 9.81954L14.7355 12.1278C14.9228 12.197 15.1292 12.197 15.3165 12.1278L21.5741 9.81954C22.1456 11.4148 22.4454 12.657 22.4932 14.3247ZM27.5381 23.6641H25.8772V22.8438C25.8772 22.1031 26.0226 21.3911 26.276 20.8904C26.4882 20.4711 26.6789 20.3828 26.7077 20.3828C26.7364 20.3828 26.9271 20.4711 27.1393 20.8904C27.3927 21.3911 27.5381 22.1031 27.5381 22.8438V23.6641Z"
                                                                fill="#01B5E8" />
                                                        </svg>
                                                    </span>
                                                <span class="title">
                                                        Образование:
                                                    </span>
                                            </div>
                                            <div class="item_right">
                                                {{ $u['userStrings']['data']->education ?: '' }}
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="item_left">
                                                    <span class="icon">
                                                        <svg width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M14.5739 9.84424H20.8867L23.1013 6.56299L20.8867 3.28174H14.5739V0.000488281H9.59114V3.28174H2.8921V9.84424H9.59114V11.4849H3.90326L0.950562 14.7661L3.90326 18.0474H9.59114V26.3599H6.26933V28.0005H17.8957V26.3599H14.5739V18.0474H21.2728V11.4849H14.5739V9.84424ZM11.252 1.64111H12.9129V3.28174H11.252V1.64111ZM4.55301 4.92236H19.9979L21.1052 6.56299L19.9979 8.20361H4.55301V4.92236ZM11.252 9.84424H12.9129V11.4849H11.252V9.84424ZM12.9129 26.3599H11.252V18.0474H12.9129V26.3599ZM19.6119 16.4067H4.64912L3.17274 14.7661L4.64912 13.1255H19.6119V16.4067Z"
                                                                fill="#01B5E8" />
                                                        </svg>
                                                    </span>
                                                <span class="title">
                                                        Направление:
                                                    </span>
                                            </div>
                                            <div class="item_right">
                                                {{ $u['userStrings']['data']->directions_raw ?: '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="section">
                                    <div class="title medium">
                                        {{ __('custom.profile_summary') }}
                                    </div>
                                    <div class="text mt-15" style="white-space: pre-line;">
                                        <p>
                                            {{ $u['userStrings']['data']->about_cut[0] ?: '' }}
                                        </p>
                                        @if(!empty($u['userStrings']['data']->about_cut[1]))
                                            <div class="collapse" id="cv-collapse">
                                                <p>
                                                    {{ $u['userStrings']['data']->about_cut[1] ?: '' }}
                                                </p>
                                            </div>
                                            <a class="link-colllapse" data-toggle="collapse" href="#cv-collapse" role="button" aria-expanded="false" aria-controls="cv-collapse">
                                                Раскрыть полностью
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @isset($u['userStrings']['data']->mediafiles_url['presentation']['file_id'])
                                    <div class="section">
                                        <div class="title medium">
                                            Видеопрезентация
                                        </div>
                                        <a class="link-to-video mt-20" data-fancybox href=" {{ $u['userStrings']['data']->mediafiles_url['presentation']['url'] ?: '' }}">
                                            <div class="link-to-video_image">
                                                @if($thumb = $u['userStrings']['data']->getFileById($u['userStrings']['data']->mediafiles_url['presentation']['file_id']))
                                                    <img src="{{ asset($thumb->file_path) ?: '' }}" alt="" title="" />
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endisset
                                <div class="section">
                                    <div class="title medium">
                                        Отзывы
                                        <span class="number">
                                                {{ $u['reviews'] }}
                                            </span>
                                    </div>
                                    <div class="reviews-list mt-30">
                                        @foreach($reviews as $review)
                                            <div class="review">
                                            <div class="review-image">
                                                <img src="/images/pages/account/item-review.svg" alt="">
                                            </div>
                                            <div class="review_info">
                                                <div class="review_info-top">
                                                    <div class="review-name">
                                                        {{ $review->name }}
                                                    </div>
                                                    <div class="review-date">
{{--                                                        {{ $review->updated_at }}--}}
                                                    </div>
                                                </div>
                                                <div class="review-rate">
                                                    @for($i=0; $i < 5; $i++)
                                                        <div class="review-rate_icon @if($i < $review->stars) active @endif">
                                                            <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z" />
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z" />
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z" />
                                                            </svg>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="review-text">
                                                    {{ $review->comment }}
                                                </div>
                                            </div>
                                        </div>
                                         @endforeach
                                    </div>
                                    <div class="buttons-group mt-40">
                                        @if((int) $u['reviews'] > 0)
                                            <a href="#" class="button dark-outline">
                                                Все отзывы
                                            </a>
                                        @endif
                                        <a href="#" class="button primary">
                                            Оставить отзыв
                                        </a>
                                    </div>
                                </div>
                                @if(!empty($files) && count($files) > 0)
                                    <div class="section">
                                        <div class="title medium">
                                            Фотографии
                                            <span class="number">
                                                        {{ count($files) }}
                                            </span>
                                        </div>
                                            <div class="photos-list  mt-10">
                                                @foreach($files as $file)
                                                    <a data-fancybox="gallery" href="{{ asset($file->file_path) }}">
                                                        <img src="{{ asset($file->file_path) }}" alt="" title="" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        <div class="border-line"></div>

                                            <div class="button dark-outline">
                                                Все фото
                                            </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection