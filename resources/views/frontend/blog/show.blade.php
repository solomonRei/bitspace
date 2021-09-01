@extends('layouts.frontend.app')
@section('content')
<div class="blog-block">
    <div class="container">
        <div class="block-container">
            <div class="wrapper">
                <div class="main-content">
                    <div class="title medium">
                        {{ $article->content->title }}
                    </div>
                    <div class="mt-20 center-md" id="breadcrumbs">
                        <ul>
                            <li>
                                <a href="/">
                                    {{ __('Main')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('blog.index.show') }}">
                                    {{ __('Blog')}}
                                </a>
                            </li>
                            <li>
                                {{ $article->content->title }}
                            </li>
                        </ul>
                    </div>
                    <div class="articles-list mt-40">
                        <div class="article">
                            @if ($article->tagsByLang->count())
                                <div class="article_tag">
                                    {{ $article->tagsByLang[0]->name }}
                                </div>
                            @endif
                            @if ($article->image)
                                <div class="article-image">
                                    <img src="/{{ $article->image->file_path }}">
                                </div>
                            @endif
                            <div class="article_info">
                                <div class="article_title {{ !$article->image ? 'mt-40' : '' }}">
                                    {{ $article->content->title }}
                                </div>
                                <div class="article_text">
                                    {!! $article->content->text !!}
                                </div>
                            </div>
                        </div>
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