@extends('layouts.front')
@section('page_title', 'Capital Nepal')
@push('styles')
@endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <section class="reporter mt mb">
        <div class="container">
            <div class="category-list">
                @isset($reporter_detail)
                    <article class="reporter-article">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="reporter-img">
                                    <x-shared-image
                                        newsimage="{{ create_image_url($reporter_detail->profile_image_url, 'thumbnail') }}"
                                        title="logo"/>
                                    {{--                                    <img src="{{ create_image_url($reporter_detail->profile_image_url, 'thumbnail') }}" alt="images">--}}
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="reporter-content">
                                    @isset($reporter_detail)
                                        <h3>{{ @get_reporter($reporter_detail) }}</h3>
                                        <ul>
                                            @isset($reporter_detail->facebook)
                                                <li class="facebook"><a href="{{ $reporter_detail->facebook }}"><i
                                                            class="fab fa-facebook-f"></i></a></li>
                                            @endisset
                                            @isset($reporter_detail->twitter)
                                                <li class="twitter"><a href="{{ $reporter_detail->twitter }}"><i
                                                            class="fab fa-twitter"></i></a></li>
                                            @endisset
                                            {{-- <li class="instagram"><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li class="linkedin"><a href="#"><i class="fab fa-linkedin"></i></a></li> --}}
                                        </ul>
                                </div>
                                @endisset
                            </div>
                        </div>
                    </article>
                @endisset
                <div class="aside-news mt">
                    <div class="row">
                        @if (isset($section1) && $section1->count())
                            @foreach ($section1 as $key => $category_news_data)
                                {{-- @if ($loop->iteration > 1 && $loop->iteration <= 4) --}}
                                <div class="col-lg-4 col-md-6">
                                    <div class="bank-sec-wrap">
                                        <div class="bank-img">
                                            <a href="{{ route('newsDetail', $category_news_data->slug) }}">
                                                <x-shared-image
                                                    newsimage="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"
                                                    title="logo"/>
                                                {{--                                            <img src="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"--}}
                                                {{--                                                class="img-responsive">--}}
                                            </a>
                                        </div>
                                        <div class="bank-content">
                                            <h2><a
                                                    href="{{ route('newsDetail', $category_news_data->slug) }}">{!! @get_title($category_news_data) !!}</a>
                                            </h2>
                                            <span class="thumb-time"><i class="far fa-clock"></i>
                                                {{ published_date($category_news_data->published_at) }}</span>
                                            <p>
                                                {{ strip_tags(parse_description($category_news_data, false, 200)) }}

                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="aside-news space-news">
                    <div class="eco-row">
                        <div class="row">
                            @if (isset($section2) && $section2->count())
                                @foreach ($section2 as $key => $category_news_data)
                                    {{-- @if ($loop->iteration > 4 && $loop->iteration <= 6) --}}
                                    <div class="col-lg-6 col-md-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 space">
                                                <div class="eco-image">
                                                    <a href="{{ route('newsDetail', $category_news_data->slug) }}">
                                                        <x-shared-image
                                                            newsimage="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"
                                                            title="logo"/>
                                                    </a>
                                                    {{--                                                    <img src="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"--}}
                                                    {{--                                                        class="img-responsive"></a>--}}
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 space">
                                                <div class="eco-content">
                                                    <h2><a
                                                            href="{{ route('newsDetail', $category_news_data->slug) }}">{!! @get_title($category_news_data) !!}</a>
                                                    </h2>
                                                    <span class="thumb-time"><i class="far fa-clock"></i>
                                                        {{ published_date($category_news_data->published_at) }}</span>
                                                    <p>
                                                        {{strip_tags( parse_description($category_news_data, false, 200))}}

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @endif --}}
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="aside-news space-news2 mt">
                    <div class="row">
                        @if (isset($section3) && $section3->count())
                            @foreach ($section3 as $key => $category_news_data)
                                {{-- @if ($loop->iteration > 6 && $loop->iteration <= 9) --}}
                                <div class="col-lg-4 col-md-6">
                                    <div class="bank-sec-wrap">
                                        <div class="bank-img"><a
                                                href="{{ route('newsDetail', $category_news_data->slug) }}">
                                                <x-shared-image
                                                    newsimage="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"
                                                    title="logo"/>
                                                {{--                                                <img--}}
                                                {{--                                                    src="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"--}}
                                                {{--                                                    class="img-responsive">--}}
                                            </a>
                                        </div>
                                        <div class="bank-content">
                                            <h2><a
                                                    href="{{ route('newsDetail', $category_news_data->slug) }}">{!! @get_title($category_news_data) !!}</a>
                                            </h2>
                                            <span class="thumb-time"><i class="far fa-clock"></i>
                                                {{ published_date($category_news_data->published_at) }}</span>
                                            <p>
                                                {{ strip_tags(parse_description($category_news_data, false, 200)) }}

                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="aside-news">
                    <div class="row">
                        @if (isset($section4) && $section4->count())
                            @foreach ($section4 as $key => $category_news_data)
                                {{-- @if ($loop->iteration > 9 && $loop->iteration <= 15) --}}
                                <div class="col-lg-4 col-md-6">
                                    <div class="thumb-news">
                                        <div class="left-img">
                                            <a href="{{ route('newsDetail', $category_news_data->slug) }}">
                                                <x-shared-image
                                                    newsimage="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"
                                                    title="logo"/>
                                            </a>
                                            {{--                                                <img--}}
                                            {{--                                                    src="{{ create_image_url($category_news_data->img_url, 'thumbnail') }}"></a>--}}

                                        </div>
                                        <div class="news-text">
                                            <h2>
                                                <a
                                                    href="{{ route('newsDetail', $category_news_data->slug) }}">{!! @get_title($category_news_data) !!}</a>
                                            </h2>
                                            <span class="thumb-time"><i class="far fa-clock"></i>
                                                {{ published_date($category_news_data->published_at) }}</span>
                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}
                            @endforeach
                        @endif

                    </div>
                </div>
                <div class="paginations">
                    {{ $reporter_news->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
