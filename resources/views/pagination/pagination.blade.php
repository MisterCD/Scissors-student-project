@if($paginator->hasPages())
<div style="display:flex;justify-content:center;gap:6px;margin-top:32px;">
    @if(!$paginator->onFirstPage())
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">Назад</a>
    @endif
    @foreach ($elements as $element)
        @if(is_array($element))
            @foreach ($element as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="page-btn page-btn--active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
     @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Вперед</a>
    @endif
</div>
@endif