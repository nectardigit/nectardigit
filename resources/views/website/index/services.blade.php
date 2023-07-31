@isset($service)
    <!-- Services -->
    @if (isset($service))
        <section class="services mt mb">
            <div class="container">
                <div class="main-title">
                    <h2>Our <span>Services</span></h2>
                    <p>We provide a range of IT related services at reasonable cost and with highest quality possible.</p>
                    <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
                </div>
                <div class="row">
                    @foreach ($service as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="service-wrap hvr-buzz-out">
                                <div class="service-icon">
                                    <img src="{{ $item['image'] ?? 'template/images/website-design.png' }}"
                                        alt="{{ $item['title'] }}">
                                </div>
                                <div class="service-content">
                                    <h3>{!! $item['title'] !!}</h3>
                                    <p>
                                        {!! str_limit(strip_tags($item['description']), 150) !!}
                                    </p>
                                    <a href="{{ route('detailpage', ['slug' => $item['slug'], 'type' => 'services']) }}">
                                        <button title="{{ $item['title'] }}" class="main-btn1">Read More</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Services End -->
@endisset
