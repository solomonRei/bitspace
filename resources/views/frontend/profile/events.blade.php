@extends('layouts.frontend.profile')
@section('main-content')
    <div class="title small">
        {{ __('custom.profile_feedback_management') }}
    </div>
    <div class="edit-reviews_list mt-25">
        @forelse($events as $event)

            <div class="review">
                <div class="review-image">
                    <img src="/images/pages/account/item-review.svg" alt="">
                </div>
                <div class="review_info">
                    <div class="review_info-top">
                        <div class="review-name">
                            {{ $event->title }}
                        </div>
                        <div class="review-date">
                            {{ $event->conference->date_of_lesson }}
                        </div>
                    </div>
                    <div class="review-text">
                        Ссылка на урок: {{ $event->conference->join_url  }} <br />
                        Код доступа: {{ $event->conference->password  }}
                    </div>
                    <a href="#" class="link-to-report deny-lesson mt-20">
                                                <span>
                                                  Отменить урок
                                                </span>
                    </a>
                </div>
            </div>
        @empty
            <p>Событий пока нет</p>
        @endforelse

        @if(!empty($events))
            <div class="pagination default center-md mt-30">
                {{ $events->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection
@section('footer-scripts')
    <script>
        $('.deny-lesson').on('click', function () {
            toastr.warning('Заявка на отмену отправлена');
        })
    </script>
@endsection
