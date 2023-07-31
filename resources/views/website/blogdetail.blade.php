@extends('layouts.front')
@section('page_title', @html_entity_decode($blogdata->title))
@push('styles')
@endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')

    <section class="bg-section"
        style="background-image: url('{{ asset(@$banner_img ?? 'template/images/bg-section.jpg') }}')">
        <div class="container">
            <div class="bg-section-wrap">

                <h1>
                    {!! html_entity_decode($blogdata->title) !!}
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" title="Home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                                {!! html_entity_decode($blogdata->title) !!}

                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->

    <!-- Blog Details Page -->
    <section class="blog-details mt mb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="blog-details-wrap">
                        <h3>{{ @html_entity_decode($blogdata->title) }}</h3>
                        <div class="blog-details-repoter-wrap">
                            <div class="blog-details-repoter-wrap-left">
                                <ul>
                                    <li><i
                                            class="fa fa-calendar"></i>{{ date('F jS, Y', strtotime(@$blogdata->created_at)) }}
                                    </li>
                                    <li><i class="fa fa-user"></i>{{ @$blogdata->publisher->name['en'] }}</li>


                                </ul>
                            </div>
                            <div class="blog-details-repoter-wrap-right">
                                <ul>
                                    <li>
                                        <div class="sharethis-inline-share-buttons"></div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <img src="{{ asset($blogdata->featured_image ?? 'template/images/bg-section.jpg') }}"
                            alt="{{ html_entity_decode($blogdata->title) }}">
                        <div class="blog-details-content">
                            <p>
                                {!! @$blogdata->description !!}
                            </p>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-5">
                    <div class="blog-sidebar">
                        <div class="blog-search sidebar-bg">
                            <form method="get" action="{{ route('page', 'blog') }}">
                                <div class="blog-search-wrap">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search...">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>

                        @if (isset($blogcategory) && count($blogcategory) > 0)
                            <div class="popular-post sidebar-bg">
                                <h3>Blog Category</h3>
                                <ul>
                                    @foreach ($blogcategory as $key => $value)
                                        <li>
                                            <div class="post-img">
                                            </div>
                                            <div class="post-content">
                                                <a href="{{ route('page', 'blog') }}">

                                                    <input type="text" name="category" value="{{ $key }}"
                                                        style="display: none">
                                                    <h4><button title="{{ @$value }}">{{ @$value }}</button>
                                                    </h4>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Page End -->
    @if (isset($related_blog))
        <!-- Related Blog -->
        <section class="related-blog pt pb">
            <div class="container">
                <div class="main-title">
                    <h2>Related <span>Posts</span></h2>
                    <p>We provide a range of IT related services at reasonable cost and with highest quality possible.</p>
                    <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
                </div>
                <div class="owl-carousel owl-theme" id="related-blog">
                    @foreach ($related_blog as $value)
                        <div class="item">
                            <div class="blog-wrap">
                                <div class="blog-img">
                                    <img src="{{ asset(@$value->featured_image ?? 'template/images/blog1.jpg') }}"
                                        alt="{{ @$value->title }}">

                                </div>
                                <div class="blog-content">
                                    <a href="{{ route('detailpage', ['slug' => $value->slug, 'type' => 'blog']) }}">
                                        <h3><button title="{{ @$value->title }}">{{ @$value->title }}</button></h3>
                                    </a>
                                    <ul>
                                        <li><i
                                                class="fa fa-calendar"></i>{{ date('F jS, Y', strtotime($value->created_at)) }}
                                        </li>
                                        <li><i class="fa fa-user"></i>{{ $value->publisher->name['en'] }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <!-- Related Blog End -->
    @endif


    @include('website.index.newsletter')

@endsection
@push('scripts')

@endpush
