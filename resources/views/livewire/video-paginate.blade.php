@if (isset($videos) && count($videos))
<div class="thumb-list-bottom">
    <div class="row">

            @foreach ($videos as $key => $video)
                <div class="col-lg-3 col-md-6">
                    <div class="thumbnail-list">

                            <div class="video-thumb">
                                <div class="thumbnail-icon">
                                    <i class="far fa-play-circle"></i>
                                </div>
                                <img src="{{ $video->Thumbnail }}" alt="images" />

                                <iframe class="iframe" width="640" height="352"
                                    src="{{ $video->Iframe }}?autoplay=1&mute=1" frameborder="0"
                                    allowfullscreen></iframe>
                                    <h3><a href="#">{{ @$video->title['np'] }}</a></h3>
                            </div>

                    </div>
                </div>
            @endforeach


    </div>
    <div class="paginations">
      {{ $videos->links('vendor.livewire.bootstrap') }}
    </div>
</div>

@endif
