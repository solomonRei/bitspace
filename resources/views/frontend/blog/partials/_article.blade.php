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
            {!! Str::limit(strip_tags($article->content->text), 250, '...') !!}
        </div>
        <a href="{{ route('blog.article.show', ['id' => $article->id]) }}" class="button dark-outline">
            {{ __('More') }}
        </a>
    </div>
</div>