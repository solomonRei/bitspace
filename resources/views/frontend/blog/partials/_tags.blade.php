<div class="sidebar_tags">
    <div class="title medium center-md">
        {{ __('Tags') }}
    </div>
    
    <ul class="tags_list">
        @foreach ($tags as $tag)
            <li>
                <a href="{{ route('blog.tag.show', ['slug' => $tag->slug]) }}">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
    </ul>
    
</div>