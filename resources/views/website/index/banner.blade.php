<!-- Banner -->
    <section class="slider">
        <div class="container">
            <div class="slider-wrap">
                <div class="slider-info">
                    <h1>
                        {{ config('texts.sliderTitle') }}
                        <a href="" class="typewrite" data-period="2000" data-type='{{ $sliders->pluck('title') }}'>
                            <span class="wrap"></span></a>
                    </h1>
                    <p>
                        {!! config('texts.sliderDescription') !!}
                </div>
                <div class="slider-img">
                    <div class="owl-carousel owl-theme" id="main-slider">
                        @foreach ($sliders as $slider)
                            <div class="item">
                                <img src="{{ $slider->image }}" alt="{{ $slider->title }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </section>
    <!-- Banner -->
