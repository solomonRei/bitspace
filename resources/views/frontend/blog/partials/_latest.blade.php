<div class="sidebar_previews-articles mt-40">
    <div class="title medium center-md">
        {{ __('Latest Articles') }}
    </div>
    <ul class="previews-articles_list">
        @foreach ($latest as $latestArticle)
        <li>
            <a href="{{ route('blog.article.show', ['id' => $latestArticle->id]) }}" class="preview-article">
                @if ($latestArticle->image)
                <div class="preview-article_image">
                    <img src="/{{ $latestArticle->image->file_path }}">
                </div>
                @endif
                
                <div class="preview-article_title">
                    {{ $latestArticle->content->title}}
                </div>
            </a>
        </li>
        @endforeach
    </ul>
</div>