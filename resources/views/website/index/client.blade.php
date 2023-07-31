{{-- {{ dd($client) }} --}}
@isset($client)
    <!-- Logo Section -->
    <section class="logo-section mb">
        <div class="container">
            <div class="logo-section-wrap">
                <div class="row">
                    <div class="col-lg-2 col-md-12">
                        <div class="logo-title">
                            <h3>Our Clients</h3>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6">
                        <div class="owl-carousel owl-theme" id="logo-section">
                            @foreach ($client as $item)
                                {{-- {{ dd($item) }} --}}
                                <div class="item">
                                    <div class="logo-section-img">
                                        <a
                                            action="{{ route('detailpage', ['type' => 'portfolio', 'slug' => $item['slug']]) }}">
                                            <button title="{{ $item['title'] }}"> <img src="{{ $item['logo'] }}"
                                                    alt="{{ $item['title'] }}"></button>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-6">
                        <div class="client-btn">
                            <a href="{{ route('page', 'protfolio') }}" class="btn btn-primary-round btn-round text-white"
                                title="Portfolio">View More Clients
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Logo Section End -->


@endisset
