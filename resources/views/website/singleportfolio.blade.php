

@extends('layouts.front')
@section('page_title', @$portfolio->title)
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
                    <li class="breadcrumb-item active" aria-current="page">{{ @$portfolio->title ?? 'Portfolio Details'}}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Bg Section End -->
{{-- {{dd($portfolio->date)}} --}}
<!-- Portfolio Details Page -->
<section class="portfolio-details pt pb">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="portfolio-details-img">
                    <img src="{{asset( @$portfolio->image ?? 'template/images/client1.png')}}" alt="images">
                </div>
            </div>
            <div class="col-md-6">
                <div class="portfolio-details-content">
                    <h3>{{@$portfolio->title}}</h3>
                    <span>{!! @$portfolio->short_description !!}</span>
                    <ul>
                        <li><i class="fa fa-code"></i> Developed By : {{@$portfolio->develop_by}}</li>
                        <li><i class="fa fa-user"></i> Clients Name : {{@$portfolio->client_name}}</li>
                        <li><i class="fa fa-calendar"></i> Date : {{date("F jS, Y", strtotime($portfolio->date))}}</li>
                    </ul>
                    <p>
                       {!! @$portfolio->description !!}
                    </p>

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
