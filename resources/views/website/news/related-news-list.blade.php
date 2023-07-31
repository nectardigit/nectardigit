@extends('layouts.front')
@section('page_title', 'Related News')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
<section class="category mt mb">
    <div class="container">

        <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">होमपेज</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">समाचार</li>
                </ol>
            </nav>
        </div>
        <div class="global-title">
            <h3>सम्बन्धित समाचार</h3>
        </div>
        <div class="category-list">
            <div class="aside-news">
                <div class="row">
                    @if(isset($news) && $news->count())
                    @foreach ($news as $item)
                    <div class="col-md-4">
                        <div class="thumb-news">
                            <div class="left-img">
                                <a href="{{ route('newsDetail', $item->slug) }}">
                                    {{-- <img src="{{ getThumbImage($item->thumbnail, $item->path) }}"> --}}
                                    <x-shared-image
                                    newsimage="{{ create_image_url($item->img_url, 'news') }}"
                                    title="{{ @get_title(@$item) }}" />
                                </a>
                                {{-- {{$item->newsHasCategories}} --}}
                                {{-- {{dd($item->categoryList($item->category))}} --}}
                                {{-- @foreach($item->categoryList($item->category) as $kry => $category)
                                <a href="#" class="category-tag">{{@$category->title['np'] ?? @$category->title['en']}}</a>
                                @endforeach --}}

                            </div>
                            <div class="news-text">
                                <h2>
                                    <a href="{{ route('newsDetail', $item->slug) }}">{{ @get_title($item) }}</a>
                                </h2>
                                <span class="thumb-time"><i class="far fa-."></i> {{ published_date($item->created_at) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="paginations">
                {{ $news->links('vendor.pagination.custom') }}
                {{-- <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item active"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav> --}}
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
