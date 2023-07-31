

@extends('layouts.front')
@section('page_title', @$pagedata->title['en'])
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
<!-- Bg Section -->
<section class="bg-section" style="background-image: url({{asset(@$pagedata->parallex_img ?? 'template/images/bg-section.jpg')}})">
    <div class="container">
        <div class="bg-section-wrap">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}" title="Home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ @$pagedata->title['en'] ?? 'Basic Page'}}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="portfolio-details pt pb">
    <div class="container">
        <div class="row">
            <div class="portfolio-details-content">
                <h3>{{@$pagedata->title['en']}}</h3>
                <span>{!! html_entity_decode(@$pagedata->short_description['en']) !!}</span>
                <p>
                   {!! html_entity_decode(@$pagedata->description['en']) !!}
                </p>
                <div>
                    @if(isset($pagedata->featured_img) && $pagedata->featured_img !='null')
                    <img src="{{asset(@$pagedata->featured_img )}}" alt="{{@$pagedata->title['en'] ?? 'Image'}}">
                    @endif
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Portfolio Details Page End -->
@include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
