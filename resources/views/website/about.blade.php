@extends('layouts.front')
@section('page_title', 'About Us')
@push('styles')
@endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    {{-- {{dd($pagedata)}} --}}
    <!-- Bg Section -->
    <section class="bg-section"
        style="background-image: url({{ asset(@$pagedata->parallex_img ?? 'template/images/bg-section.jpg') }})">
        <div class="container">
            <div class="bg-section-wrap">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" title="Home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->

    <!-- About Us -->
    <section class="about-us pt pb">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-6 col-md-12">
                    <div class="about-us-img">
                        @if (isset($pagedata->featured_img) || file_exists($pagedata->featured_img))
                            <img src="{{ asset($pagedata->featured_img) }}"
                                alt="{{ $pagedata->title[app()->getLocale()] }}">
                        @else
                            <img src="{{ asset('template/images/about-us.png') }}" alt="images">
                        @endif
                    </div>
                </div> --}}
                <div class="col-lg-12 col-md-12">
                    <div class="about-us-content">
                        @if (isset($pagedata->short_description))
                            <h2><b> {!! html_entity_decode(@$pagedata->short_description['en']) !!}</b> </h2>
                        @endif
                        {{-- <span>Trusted Business Growing Service Provider</span> --}}
                        @if (isset($pagedata->description))
                            <p>
                                {!! html_entity_decode(@$pagedata->description['en']) !!}
                            </p>
                        @endif


                    </div>
                </div>
            </div>
            {{-- Mission/Vision --}}
            @if (isset($mission))
                <div class="mission">
                    <div class="row">
                        @foreach ($mission as $value)
                            <div class="col-lg-4 col-md-6">
                                <div class="mission-wrap hvr-buzz-out">
                                    <i class="{{ $value->icon }}"></i>
                                    <span>{{ $value->title }}</span>
                                    <p>
                                        {!! $value->description !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- End Mission/Vision --}}

        </div>
    </section>
    <!-- About Us End -->
    {{-- {{ dd($customer_satisfy)}} --}}
    <!-- How Section -->
    @if (isset($customer_satisfy))
        <section class="how-section pt pb">
            <div class="container">
                <div class="main-title">
                    <h2>Satisfy Our <span>Customer</span></h2>
                    <p>We provide a range of IT related services at reasonable cost and with highest quality possible.</p>
                    <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
                </div>
                <div class="row">
                    @foreach ($customer_satisfy as $value)
                        <div class="col-lg-4 col-md-6">
                            <div class="how-section-wrap hvr-buzz-out">
                                {{-- <i class="{{ $value->icon }}"></i> --}}
                                <img src="{{ $value->image }}" alt="">
                                <h3>{{ $value->title }}</h3>
                                <p>
                                    {!! $value->description !!}
                                </p>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </section>
    @endif
    <!-- How Section End -->
    @include('website.index.newsletter')


@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
