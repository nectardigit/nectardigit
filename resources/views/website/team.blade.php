@extends('layouts.front')
@section('page_title', 'Our Team')
@push('styles')
@endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')

    <!-- Bg Section -->
    <section class="bg-section"
        style="background-image: url({{ asset(@$pagedata->parallex_img ?? 'template/images/bg-section.jpg') }})">
        <div class="container">
            <div class="bg-section-wrap">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" title="Home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ @$pagedata->title['en'] ?? 'Team' }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->
    <!-- Team Page -->
    <section class="team-page mt">
        <div class="container">
            {{-- <div class="main-title">
            <h2>{!! html_entity_decode(@$pagedata->short_description['en']) !!}</span></h2>
            <p>{!! html_entity_decode(@$pagedata->description['en']) !!}</p>
            <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
        </div> --}}
            @if (isset($team))
                <div class="row">
                    {{-- {{dd($team)}} --}}
                    @foreach ($team as $value)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="team-wrap">
                                <div class="team-img">
                                    <img src="{{ asset($value->image ?? 'template/images/blog1.jpg') }}"
                                        alt="{{ @$value->full_name['en'] }}">
                                    <div class="social-media">
                                        <ul>

                                            <li><a href="{{ @$value->facebook }}" title="{{ @$value->full_name['en'] }}"
                                                    target="_blank"><i class="fa fa-facebook"></i></a></li>


                                            <li><a href="{{ @$value->twitter }}" title="{{ @$value->full_name['en'] }}"
                                                    target="_blank"><i class="fa fa-twitter"></i></a></li>


                                            <li><a href="{{ @$value->instagram }}" title="{{ @$value->full_name['en'] }}"
                                                    target="_blank"><i class="fa fa-instagram"></i></a></li>


                                            <li><a href="{{ @$value->youtube }}" title="{{ @$value->full_name['en'] }}"
                                                    target="_blank"><i class="fa fa-youtube-play"></i></a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="team-content">
                                    <a href="{{ route('detailpage', ['type' => 'team', 'slug' => $value->slug]) }}">
                                        <button>
                                            <span>{{ @$value->full_name['en'] }}</span>
                                            <p>{{ @$value->designation->title['en'] }}</p>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Team Page End -->
    @include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
