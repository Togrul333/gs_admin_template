@if ($paginator->hasPages())
    <div class="pagination">
        <a href="{{ $paginator->previousPageUrl() . '&popup=second'}}">
            <img class="pagination_left" src="{{ asset('frontend/assets/images/left_pag.svg') }}" alt="Previous Page"/>
        </a>
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="{{ $url  . '&popup=second'}}"><p class="pagination_item pagination_active">{{ $page }}</p></a>
                    @elseif($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->lastPage() || $page === 1)
                        <a href="{{ $url . '&popup=second'}}"><p class="pagination_item">{{ $page }}</p></a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() . '&popup=second' }}">
                <img
                    class="pagination_right"
                    src="{{asset('frontend/assets/images/right_pag.svg')}}"
                    alt="right"
                />
            </a>
        @endif
    </div>
@endif
