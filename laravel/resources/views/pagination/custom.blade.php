@if ($paginator->hasPages())
   
    <ul class="pagination pagination-sm mb-0 justify-content-md-end flex-shrink-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link"><i class="fa-regular fa-arrow-left"></i></span></li>
        @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" id="btn-prev" class="btn-paginate"><span class="page-link"><i class="fa-regular fa-arrow-left"></i></span></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}"><span class="page-link">{{ $page }}</span></a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next" id="btn-next" class="btn-paginate"><span class="page-link"><i class="fa-regular fa-arrow-right"></i></span></a></li>
        @else
            <li class="page-item disabled"><span class="page-link"><i class="fa-regular fa-arrow-right"></i></span></li>
        @endif
    </ul>
@endif

