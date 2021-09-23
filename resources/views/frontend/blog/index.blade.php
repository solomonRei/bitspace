@extends('layouts.frontend.app')
@section('content')
    <div class="blog-block">
        <div class="container">
            <div class="block-container">
                <div class="wrapper">
                    <div class="main-content">
                        <div class="title medium center-md">
                            {{ __('Blog') }}
                        </div>
                        <div class="mt-20 center-md" id="breadcrumbs">
                            <ul>
                                <li>
                                    <a href="/">
                                        {{ __('Main')}}
                                    </a>
                                </li>
                                <li>
                                    {{ __('Blog') }}
                                </li>
                            </ul>
                        </div>
                        <div class="articles-list mt-40">
                            @if ($articles->count())
                                @foreach ($articles as $article)
                                    @include('frontend.blog.partials._article', [
                                        'article' => $article
                                    ])
                                @endforeach
                                {!! $articles->links('vendor.pagination.custom') !!}
                            @else
                                <p class="text-center">
                                    {{ __('No articles found') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="sidebar">
                        @if ($tags->count())
                            @include('frontend.blog.partials._tags', [
                                'tags' => $tags
                            ])
                        @endif
                        @if ($latest->count())
                            @include('frontend.blog.partials._latest', [
                                'latest' => $latest
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
