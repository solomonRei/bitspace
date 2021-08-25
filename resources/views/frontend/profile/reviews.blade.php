@extends('layouts.frontend.profile')
@section('main-content')
    <div class="title small">
        {{ __('custom.profile_feedback_management') }}
    </div>
    <div class="edit-reviews_list mt-25">
        @forelse($reviews as $review)

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
{{--                            {{ $review->updated_at }}--}}
                        </div>
                    </div>
                    <div class="review-rate">
                        @include('layouts.frontend.partials.stars', ['stars' => $review->stars, 'icon_class' => 'review-rate_icon'])
                    </div>
                    <div class="review-text">
                        {{ $review->comment }}
                    </div>
                    <a href="{{ route('profile.reviews.complain', ['id' => $review->id]) }}" class="link-to-report mt-20">
                                                <span>
                                                    Обжаловать отзыв
                                                </span>
                    </a>
                </div>
            </div>
        @empty
            <p>Отзывов пока что нет</p>
        @endforelse

        @if(!empty($reviews))
            <div class="pagination default center-md mt-30">
                {{ $reviews->links('vendor.pagination.custom') }}
            </div>
         @endif
    </div>
@endsection
