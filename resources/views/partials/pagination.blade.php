@if ($paginator->hasPages())
    <ul class="pagination">
    {{-- Pagination Elements --}}
    <!-- Pagination Elements -->
        @if (!$paginator->onFirstPage())
            <li class="pagination-page">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif
        @foreach ($elements as $element)
        <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                <!--  Use three dots when current page is greater than 4.  -->
                    @if ($paginator->currentPage() > 4 && $page === 2)
                        <li class="pagination-page">
                            <span class="products__inner-right__content-bottom__dots-item">...</span>
                        </li>
                    @endif

                <!--  Show active page else show the first and last two pages from current page.  -->
                    @if ($page == $paginator->currentPage())
                        <li class="pagination-page active">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->lastPage() || $page === 1)
                        <li class="pagination-page">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif

                <!--  Use three dots when current page is away from end.  -->
                    @if ($paginator->currentPage() < $paginator->lastPage() - 3 && $page === $paginator->lastPage() - 1)
                        <li class="pagination-page">
                            <span class="products__inner-right__content-bottom__dots-item">...</span>
                        </li>
                    @endif

                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="pagination-page">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @endif
    </ul>
@endif

