@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination">
       
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="{{ $paginator->previousPageUrl() }}" rel="prev"><span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span></a></li>
        @else
            <li class="page-item"><a class="page-link" aria-label="Previous" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span></a></li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">
                <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span></a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next"><span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span></a></li>
        @endif
    </ul>
</nav>
@endif 

