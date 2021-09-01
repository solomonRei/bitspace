<div class="filters-search-block">
    <div class="container">
        <div class="block-container">
            <div id="breadcrumbs">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">
                            Главная
                        </a>
                    </li>
                    <li>
                        {{ $categoryName }}
                    </li>
                </ul>
            </div>
            <div class="wrapper">
                <div class="sidebar">
                    <div class="sidebar_search-filters">
                        <div class="title medium">
                            
                        </div>
                        <div class="form-groups mt-30">
                            <div class="form-groups_title">
                                Город
                            </div>
                            <div id="city-select-control" class="form-control" wire:ignore>
                                <select id="city-select" class="custom-select" placeholder="Выберите город">
                                    @foreach($citiesList as $key => $cityName)
                                        <option value="{{ $key }}" @if ($city == $key)
                                            {{ "selected='selected'" }}
                                        @endif>{{ $cityName }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-groups mt-50">
                            <div class="form-groups_title">
                                Возрастные группы
                            </div>
                            
                            <div class="form-control_checkboxes">
                                @foreach($groupsList as $key => $groupName)
                                <div class="form-control checkbox">
                                    <input type="checkbox" id="groups-{{ $key }}" value="{{ $key }}" wire:model='groups.{{ $key }}'>
                                    <label for="groups-{{ $key }}">
                                        {{ $groupName }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-groups  mt-30">
                            <div class="form-groups_title">
                                Показывать
                            </div>
                            <div class="form-control checkbox">
                                <input id="profiles-with-photo" type="checkbox" value="1" wire:model='withPhoto'>
                                <label for="profiles-with-photo">
                                    Только с фото
                                </label>
                            </div>
                            <div class="form-control checkbox">
                                <input id="profiles-with-review" type="checkbox" value="1" wire:model='withReview'>
                                <label for="profiles-with-review">
                                    Только с отзывами
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content">
                    <div class="result-list">
                        @if ($users->count())
                            @foreach ($users as $person)
                                <div class="item ">
                                    <div class="item_container">
                                        <div class="item_left">
                                            <div class="item_image">
                                                @if(isset($person->ava) && @$ava = $person->getFileById($person->ava))
                                                    <img src="{{ asset($ava->file_path) }}" alt="">
                                                @else
                                                    <img src="{{ asset(config('app.default_ava')) }}" alt="">
                                                @endif
                                            </div>
                                            <div class="item-rate">
                                                @php
                                                    $stars = $person->reviews->avg('stars');
                                                @endphp
                                                @for ($i = 1; $i < 6; $i++)
                                                    @if ($i <= $stars)
                                                        <div class="item-rate_icon active">
                                                            <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z">
                                                                </path>
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z">
                                                                </path>
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="item-rate_icon">
                                                            <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z">
                                                                </path>
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z">
                                                                </path>
                                                                <path
                                                                    d="M6.60326 0.816985C6.97008 0.0737393 8.02992 0.07374 8.39674 0.816986L9.76542 3.59024C9.91108 3.88538 10.1926 4.08995 10.5184 4.13728L13.5788 4.58199C14.399 4.70117 14.7265 5.70915 14.133 6.28768L11.9185 8.44636C11.6828 8.67609 11.5752 9.00709 11.6309 9.33149L12.1537 12.3796C12.2938 13.1965 11.4363 13.8195 10.7027 13.4338L7.96534 11.9946C7.67402 11.8415 7.32598 11.8415 7.03466 11.9946L4.2973 13.4338C3.56367 13.8195 2.70624 13.1965 2.84635 12.3796L3.36914 9.33149C3.42478 9.00709 3.31723 8.67609 3.08154 8.44636L0.866968 6.28768C0.273451 5.70915 0.600962 4.70117 1.42118 4.58199L4.48165 4.13728C4.80736 4.08995 5.08892 3.88538 5.23458 3.59024L6.60326 0.816985Z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="item_link-to-reviews">
                                                {{ $person->reviews->count() }} отзывов
                                            </div>
                                        </div>
                                        <div class="item_right">
                                            <div class="item_category">
                                                @if ($person->categoryName)
                                                    {{ $person->categoryName->name }}
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                                <div class="item_name">
                                                    @if($person->userStringsByLang)
                                                        {{ $person->userStringsByLang->name }}
                                                    @endif
                                                </div>
                                                <a href="{{ route('profileUser.show', ['id' => $person->id]) }}" class="item_link-to-profile mt-5 mt-md-0">
                                                    Смотреть профиль
                                                </a>
                                            </div>
                                            <div class="item-add-info">
                                                @if($person->userStringsByLang)
                                                <div class="item-add-info_line">
                                                        <span class="icon">
                                                            <svg width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M14.5739 9.84424H20.8867L23.1013 6.56299L20.8867 3.28174H14.5739V0.000488281H9.59114V3.28174H2.8921V9.84424H9.59114V11.4849H3.90326L0.950562 14.7661L3.90326 18.0474H9.59114V26.3599H6.26933V28.0005H17.8957V26.3599H14.5739V18.0474H21.2728V11.4849H14.5739V9.84424ZM11.252 1.64111H12.9129V3.28174H11.252V1.64111ZM4.55301 4.92236H19.9979L21.1052 6.56299L19.9979 8.20361H4.55301V4.92236ZM11.252 9.84424H12.9129V11.4849H11.252V9.84424ZM12.9129 26.3599H11.252V18.0474H12.9129V26.3599ZM19.6119 16.4067H4.64912L3.17274 14.7661L4.64912 13.1255H19.6119V16.4067Z"
                                                                    fill="#444444"></path>
                                                            </svg>

                                                        </span>
                                                    
                                                    {{ $person->userStringsByLang->directions_raw }}
                                                    
                                                </div>
                                                @endif
                                                @if ($person->groupName)
                                                <div class="item-add-info_line">
                                                        <span class="icon">
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="7.53842" cy="5.38462" r="4.63462" stroke="#444444" stroke-width="1.5"></circle>
                                                                <circle cx="20.4615" cy="5.38462" r="4.63462" stroke="#444444" stroke-width="1.5"></circle>
                                                                <path d="M0.75 16.6923C0.75 13.2405 3.54822 10.4423 7 10.4423H12.1538C13.9488 10.4423 15.4038 11.8973 15.4038 13.6923V19.7115H0.75V16.6923Z" stroke="#444444" stroke-width="1.5"></path>
                                                                <path d="M12.5962 13.6923C12.5962 11.8973 14.0513 10.4423 15.8462 10.4423H21C24.4518 10.4423 27.25 13.2405 27.25 16.6923V19.7115H12.5962V13.6923Z" stroke="#444444" stroke-width="1.5"></path>
                                                                <circle cx="14.0001" cy="10.7692" r="3.55769" fill="white" stroke="#444444" stroke-width="1.5"></circle>
                                                                <path d="M8.28857 19C8.28857 16.6528 10.1914 14.75 12.5386 14.75H15.4616C17.8089 14.75 19.7117 16.6528 19.7117 19V21.8654H8.28857V19Z" fill="white" stroke="#444444" stroke-width="1.5">
                                                                </path>
                                                            </svg>

                                                        </span>
                                                    
                                                    {{ $person->groupName->name }}
                                                    
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">
                                {{ __('No profiles found') }}
                            </p>
                        @endif
                    </div>
                    <div class="pagination default center mt-50">
                        {{ $users->links('vendor.pagination.custom') }}
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>

    $('#city-select').on('input', function(e) {
        @this.set('city', this.value)
    })

</script>

@endpush