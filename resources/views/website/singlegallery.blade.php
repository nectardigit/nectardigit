

@extends('layouts.front')
@section('page_title', @$gallery->title)
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
<!-- Bg Section -->
<section class="bg-section" style="background-image: url({{asset(@$banner_img ?? 'template/images/bg-section.jpg')}})">

    <div class="container">
        <div class="bg-section-wrap">
            <h1>{{ @$gallery->title?? 'gallery Details'}}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}" title="Home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ @$gallery->title ?? 'gallery Details'}}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Bg Section End -->



@if(isset($gallery))
<!-- Gallery Details Page -->
<section class="gallery-details mt">
    <div class="container">
        <h3>{{@$gallery->title}}</h3>
        <div class="demo-gallery">
            <ul id="lightgallery" class="list-unstyled row">
                @foreach ($gallery->gallery_images as $img)
                <li class="col-lg-3 col-md-4 col-sm-6" data-responsive="" data-src="{{asset(@$img ?? 'template/images/blog1.jpg')}}" data-sub-html="" data-pinterest-text="" data-tweet-text="">
                    <a href="">
                        <img class="img-responsive" src="{{asset(@$img ?? 'template/images/blog1.jpg')}}" alt="images">
                        <i class="fa fa-arrows-alt"></i>
                        <span>{{@$gallery->title}}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        
        {{-- <div class="gallery-details-wrap">
            <ul class="row">
                @foreach ($gallery->gallery_images as $img)
                <li class="col-lg-3 col-md-4 col-sm-6">
                    <a class="example-image-link" href="{{asset(@$img ?? 'template/images/blog1.jpg')}}" data-lightbox="example-set" data-title="{{@$gallery->title}}"><img class="example-image" src="{{asset(@$img ?? 'tempalte/images/blog1.jpg')}}" alt="{{@$gallery->title}}"/>
                        <span>{{@$gallery->title}}</span>
                    </a>
                </li>
                @endforeach


            </ul>
        </div> --}}
    </div>
</section>
<!-- Gallery Details Page End -->
@endif
@include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush


