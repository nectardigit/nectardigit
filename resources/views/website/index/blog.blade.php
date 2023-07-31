<!-- Blog -->
{{-- {{dd($blog)}} --}}
@if (isset($blog))
    <div class="container">
        <div class="main-title">
            <h2>Our Latest <span>Blog</span></h2>
            <p>We provide a range of IT related services at reasonable cost and with highest quality possible.</p>
            <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
        </div>
        <div class="row">
            @foreach ($blog as $value)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-wrap">
                        <div class="blog-img">
                            @if (isset($value->featured_image))
                                <img src="{{ asset($value->featured_image) }}" alt="{{ $value->title }}">
                            @else
                                <img src="{{ asset('template/images/blog1.jpg') }}" alt="{{ $value->title }}">
                            @endif
                        </div>
                        <div class="blog-content">
                            <a href="{{ route('detailpage', ['type' => 'blog', 'slug' => $value->slug]) }}">
                                <h3><button title="{{ $value->title }}">{!! $value->title !!}</button></h3>
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
<!-- Blog End -->
