<div class="comon-ads mt mb">
    <div class="row">
        @if ($inside_content_ad && $inside_content_ad->count())
            @foreach ($inside_content_ad as $key => $advertise)
                @include('layouts.advertise-section')
            @endforeach
        @endif
    </div>
</div>