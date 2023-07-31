
{{-- {{dd($videos)}} --}}
<!-- Video Section -->
@if (isset($videos))
<section class="video-section mb" data-background="{{asset('template/images/bg7.png')}}" data-overlay-dark="8" style="background-image: url({{asset('template/images/bg7.png')}});">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="videos-section-content">
                    <span>How we satisfy you</span>
                    <h2>{{@$videos->title['en']}}</h2>
                    <p>
                        {!! html_entity_decode(@$videos->description['en']) !!}
                    </p>
                    <div class="video-popup">
                        <a class="popup-youtube-left pulse1" href="{{@$videos->url}}" target="_blank"><i class="fa fa-play"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="video-section-img">
                    <img src="{{asset(@$videos->image ?? 'template/images/videos-img.jpg')}}" alt="{{@$videos->title['en']}}">
                </div>
            </div>
        </div>
    </div>
</section>

@endif
<!-- Video Section End -->
