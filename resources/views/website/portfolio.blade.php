{{-- {{dd($pagedata)}} --}}

@extends('layouts.front')
@section('page_title', @$pagedata->title['en'])
@push('styles')
@endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <!-- Bg Section -->
    <section class="bg-section"
        style="background-image: url('{{ asset($pagedata->parallex_img ?? 'template/images/bg-section.jpg') }}')">
        <div class="container">
            <div class="bg-section-wrap">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ @$pagedata->title['en'] ?? 'Portfolio' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>


    <!-- Bg Section End -->
    {{-- {{dd($portfolio)}} --}}
    @if (isset($portfolio))
        <!-- Portfolio Page -->
        <section class="portfolio-page mt">
            <div class="container">
                {{-- <div class="main-title">
                    <h2>{!! html_entity_decode(@$pagedata->short_description['en']) !!}</h2>
                    <p>{!! html_entity_decode(@$pagedata->description['en']) !!}</p>
                    <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
                </div> --}}
                <div class="row">
                    @foreach ($portfolio as $value)
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="portfolio-wrap hvr-wobble-bottom">
                                <a href="{{ route('detailpage', ['slug' => $value->slug, 'type' => 'portfolio']) }}"
                                   >
                                    <button title="{{ @$value->title }}">


                                        <div class="portfolio-img">
                                            <img src="{{ asset(@$value->logo) }}" alt="{{ @$value->title }}">
                                        </div>
                                        <div class="portfolio-content">
                                            <span>{{ @$value->title }}</span>
                                        </div>
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <div class="pagination-item">
            {{ $portfolio->links() }}
        </div>
        <!-- Portfolio Page End -->
    @endif
    @include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
