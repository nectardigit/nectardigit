
<div class="">
    @if($loadFooterVideo)
    @if (isset($footerVideo) && $footerVideo->count())
        <div class="video-popup-wrap">
            <div class="video-popup">
                <div class="close-video">
                    <i class="fas fa-times"></i>
                </div>
                <div class="video-selected">
                    <div class="video-iframe">
                        <iframe width="300" height="500" src="{{ $footerVideo->Iframe }}?autoplay=1&mute=1"
                            frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endif

</div>
