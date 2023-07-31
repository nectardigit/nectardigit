<div class="row">

    @if (isset($iteration))
        @foreach ($advertisements->take($iteration) as $key => $advertisement)
            <div class="{{ @$advertisement->columnType }} {{ checkdevice(@$advertisement->show_on) }}">
                @if (isset($sidebar) && $loop->first)
                    <div class="sidebar-ads">
                @endif
                <a href="{{ $advertisement->url }}">
                    <img src="{{ !$device && ($advertisement->show_on  == 'app' || @$advertisement->img_url_app) ?  @$advertisement->img_url_app : @$advertisement->img_url }}" alt="images"></a>
                @if (isset($sidebar) && $loop->last)
                    </div>
                @endif
            </div>
        @endforeach
    @else
    
        @foreach ($advertisements as $key => $advertisement)
            <div class="{{ @$advertisement->columnType }} {{ checkdevice(@$advertisement->show_on) }}">
                @if (isset($sidebar) && $loop->first)
                    <div class="sidebar-ads">
                @endif
                <a href="{{ $advertisement->url }}">
                    <img src="{{ !$device && ($advertisement->show_on  == 'app' || @$advertisement->img_url_app) ?  @$advertisement->img_url_app : @$advertisement->img_url }}" alt="images"></a>
                @if (isset($sidebar) && $loop->last)
                    </div>
                @endif
            </div>
        @endforeach
    @endif

</div>
