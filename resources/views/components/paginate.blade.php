<div class="paginateBlock">
    @if ($paginator->hasPages())
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" class="btn hoverBtn" rel="prev"><</a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><button class="btn hoverBtn disabled"><span>{{ $element }}</span></button></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($paginator->currentPage() <= $loop->iteration+1)
                            @if ($page == $paginator->currentPage())
                                <li><button><span>{{ $page }}</span></button></li>
                            @elseif($page != $loop->count)
                                <li><a href="{{ $url }}" class="btn hoverBtn"><span>{{ $page }}</span></a></li>
                            @endif
                        @endif

                        @if ($paginator->currentPage() < $page)
                            @if($paginator->currentPage() != $loop->count-1)
                                <li><a class="btn hoverBtn"><span>...</span></a></li>
                            @endif
                            <li><a href="{{ Request::url()."?page=".$loop->count }}" class="btn hoverBtn"><span>{{ $loop->count }}</span></a></li>
                            @break
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" class="btn hoverBtn" rel="next">></a></li>
            @else
                <li></li>
            @endif
        </ul>
    @endif
</div>
