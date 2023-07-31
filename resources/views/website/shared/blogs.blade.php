@extends('layouts.front')
@section('page_title', 'Blogs')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')

        <!-- header -->
        <header class="page-title page-bg" style="background-image: url({{ asset('/uploads/contents/'.@$pagedata->parallex_img) }});">
            <div class="container">
                <div class="page-title-inner">
                    <div class="section-title">
                        <h1>Blogs</h1>
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Blogs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- .end header -->
        <!-- blog-page-section -->
        <section class="blog-page-section p-tb-100">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8 order-2 order-lg-1">
                        <div class="blog-details-inner pr-40">
                            @foreach ($blogs as $blog)
                            <div class="blog-post-item">
                                <div class="blog-post-thumb">
                                    <a href="{{ url('/blog/'.$blog->slug) }}">
                                        <img src="{{ asset('/uploads/blogs/'.$blog->featured_img) }}" alt="blog">
                                    </a>
                                </div>
                                <div class="blog-post-details">
                                    <ul class="blog-post-entry">
                                        @foreach ($blog->categories as $cate)
                                        <li>{{ $cate->title }}</li>
                                        @endforeach
                                        <li>{{ $blog->date }}</li>
                                    </ul>
                                    <h3 class="blog-post-title mt-15"><a href="{{ url('/blog/'.$blog->slug) }}">{{ $blog->title }}</a></h3>
                                    <p class="blog-post-para mt-15">{!! $blog->description !!}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{ $blogs->links() }}
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 order-1 order-lg-2">
                        <div class="blog-sidebar">
                            {{-- <div class="blog-sidebar-item">
                                <div class="blog-sidebar-item-header">
                                    <h3 class="sub-section-title">Search</h3>
                                </div>
                                <div class="blog-sidebar-item-details blog-search-area">
                                    <div class="input-area">
                                        <input type="text" class="input-full" placeholder="Search...">
                                        <button class="btn-with-image orange-gradient btn1">
                                            <img src="assets/images/search.png" alt="logo">
                                            <img src="assets/images/search.png" alt="logo">
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="blog-sidebar-item">
                                <div class="blog-sidebar-item-header">
                                    <h3 class="sub-section-title">Categories</h3>
                                </div>
                                <div class="blog-sidebar-item-details blog-category-details">
                                    {{-- {{ dd($categories) }} --}}
                                    @foreach ($categories as $category)
                                    <div class="blog-category-item">
                                        <h4 class="blog-category-name"><a href="{{ url('/category/'.$category->slug) }}">{{ $category->title }}</a></h4>
                                        <div class="blog-cateogory-divider"></div>
                                        <h5 class="blog-category-number">{{ count($category->blogs) }}</h5>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="blog-sidebar-item">
                                <div class="blog-sidebar-item-header">
                                    <h3 class="sub-section-title">Tags</h3>
                                </div>
                                <div class="blog-sidebar-item-details blog-sidebar-tag-details">
                                    <ul class="blog-sidebar-tag-list">
                                        @foreach ($tags as $tag)
                                        {{-- {{ dd($tag) }} --}}
                                        <li class="blog-sidebar-tag-lg"><a href="{{ url('/tag/'.$tag->slug) }}">{{ $tag->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--end testimonial-page-section-->
 

@endsection
@push('scripts')
{{-- scripts here --}}
@endpush