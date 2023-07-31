@extends('layouts.front')
@section('page_title', $pagedata->title['en'])
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
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Services</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->
    <!-- Service Page -->
    <section class="service-page mt">
        <div class="container">
            <div class="main-title">
                <h2>{!! html_entity_decode($pagedata->short_description['en']) !!}</h2>
                <p>{!! html_entity_decode($pagedata->description['en']) !!}</p>
                <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
            </div>

            {{-- {{dd($service)}} --}}
            @if (isset($service) && !empty($service))
                <div class="row">
                    @foreach ($service as $value)
                        <div class="col-lg-4 col-md-6">
                            <div class="service-wrap hvr-buzz-out">
                                <div class="service-icon">
                                    <img src="{{ $value->image ?? 'template/images/website-design.png' }}"
                                        alt="{{ $value->title }}">
                                </div>
                                <div class="service-content">
                                    <h3>{!! $value->title !!}</h3>
                                    <p>
                                        {!! str_limit(strip_tags($value->description), 150) !!}
                                    </p>
                                    <a href="{{ route('detailpage', ['slug' => $value->slug, 'type' => 'services']) }}">
                                        <button title="{{ $value->title }}" class="main-btn1">Read More</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            @endif
        </div>
    </section>
    <div class="pagination-item">
        {{ $service->links() }}
    </div>
    <!-- Service Page End -->
    @include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
