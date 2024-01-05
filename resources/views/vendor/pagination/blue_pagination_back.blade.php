@if ($paginator->hasPages())
<div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
    <ul class="pagination">

        <li class="paginate_button page-item previous disabled" id="datatable_previous">
            <a href="{{ $paginator->previousPageUrl() }}" aria-controls="datatable"
               data-dt-idx="0" tabindex="0" class="page-link">Öncəki</a>
        </li>
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="paginate_button page-item active">
                            <a href="{{ $url }}" aria-controls="datatable" data-dt-idx="1"
                               tabindex="0" class="page-link">{{ $page }}</a>
                        </li>
                        <a href="{{ $url }}"><p class="pagination_item pagination_active">{{ $page }}</p></a>
                    @elseif($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2
                        || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2
                        || $page === $paginator->lastPage() || $page === 1)
                        <li class="paginate_button page-item ">
                            <a href="{{ $url }}"  aria-controls="datatable"
                               data-dt-idx="2" tabindex="0" class="page-link">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="paginate_button page-item next" id="datatable_next">
                <a href="{{ $paginator->nextPageUrl() }}" aria-controls="datatable"
                   data-dt-idx="8" tabindex="0" class="page-link">Sonrakı</a>
            </li>
        @endif
    </ul>
</div>
@endif
