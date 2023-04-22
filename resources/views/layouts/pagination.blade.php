@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())
        <a href="#" class="prev-button" disabled>Prev</a>
    @else
    <a href="{{ $paginator->previousPageUrl()}}" class="prev-button">Prev</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <a href="">{{ $element }}</a>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a href="#" class="page-button active">{{ $page }}</a>
                @else
                    <a href="{{ $url }}" class="page-button ">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
      @if ($paginator->hasMorePages())
        <a href="{{$paginator->nextPageUrl()}}" class="next-button">Next</a>
      @else
        <a href="#" class="next-button">Next</a>
      @endif
      
@endif