@if ($paginator->hasPages())
    <nav class="admin__pagination" role="navigation" aria-label="Навигация по страницам">
        @if ($paginator->onFirstPage())
            <span class="admin__page-link is-disabled">←</span>
        @else
            <a class="admin__page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="admin__page-link is-disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="admin__page-link is-active">{{ $page }}</span>
                    @else
                        <a class="admin__page-link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="admin__page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">→</a>
        @else
            <span class="admin__page-link is-disabled">→</span>
        @endif
    </nav>
@endif
