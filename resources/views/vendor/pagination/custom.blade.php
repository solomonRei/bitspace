
@if ($paginator->hasPages())
    <ul>

        @if ($paginator->onFirstPage())
            <li class="prev-button">
                <a href="#"></a>
            </li>
        @else
            <li class="prev-button"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"></a></li>
        @endif


        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="disabled">
                    <a href="#">{{ $element }}</a>
                </li>
            @endif



            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active">
                            <a href="#">{{ $page }}</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach



        @if ($paginator->hasMorePages())
            <li class="next-button">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"></a>
            </li>
        @else
            <li class="next-button disabled">
                <a href="#"></a>
            </li>
        @endif
    </ul>
@endif
