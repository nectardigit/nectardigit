@extends('layouts.front')
@section('page_title', @$categoryInfo->title['np'])
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6052e0d61b52e2a6"></script>

    <section class="category mt mb">
        <div class="container">
            <div class="breadcrumbs">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('index') }}">होमपेज</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            @if (isset($categoryInfo))
                                {{ @get_title($categoryInfo) }}
                            @else
                                {{ app()->getLocale() == 'np' ? 'क्यापिटल विशेष' : 'Capital Bishesh' }}
                            @endif
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="global-title">
                <h3>
                    @if (isset($categoryInfo))
                        {{ @get_title($categoryInfo) }}
                    @else
                        {{ app()->getLocale() == 'np' ? 'क्यापिटल विशेष' : 'Capital Bishesh' }}
                    @endif
                </h3>
            </div>
            @if (isset($category_news) && $category_news->count())
                <div class="category-list">

                    <article class="article">
                        <div class="row">
                            {{-- {{dd($meta)}} --}}
                            {{-- @foreach ($category_news->categoriesHasNews as $key => $category_news_data) --}}
                            @if (isset($banner_news) && $banner_news->count())
                                @foreach ($banner_news as $key => $category_news_data)
                                    {{-- dd($category_news_data) --}}
                                    {{-- @if ($loop->iteration == 1) --}}
                                    <div class="col-lg-7 col-md-12">
                                        <div class="article-img">
                                            <x-shared-image
                                                newsimage="{{ create_image_url($category_news_data->img_url, 'banner') }}"
                                                title="{{ @get_title($category_news_data) }}" />

                                            {{-- @if (!isset($categoryInfo))
                                        <a href="{{ route('newsDetail', $category_news_data->slug) }}"
                                        class="category-tag">
                                    {{app()->getLocale() == 'np'? 'क्यापिटल विशेष':'Capital Bishesh'}}
                                         </a>
                                        @endif --}}


                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <div class="article-content">
                                            <h3><a
                                                    href="{{ route('newsDetail', $category_news_data->slug) }}">{!! @get_title($category_news_data) !!}</a>
                                            </h3>
                                            <div class="sub-text">
                                                <ul>
                                                    <li>

                                                        {{-- {{ dd($category_news_data->news_reporters) }} --}}
                                                        @if (isset($category_news_data) && $category_news_data->news_reporters && $category_news_data->news_reporters->count())
                                                            <i class="far fa-user"></i>
                                                            @foreach ($category_news_data->news_reporters as $reporter)

                                                                <a target="_blank"
                                                                    href="{{ route('getReporter', trim($reporter->slug)) }}">{{ $reporter->name['np'] }}
                                                                </a>
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif

                                                            @endforeach
                                                        @elseif (!$category_news_data->news_reporters->count())
                                                            <a
                                                                href="{{ route('getUser', @$category_news_data->user->slug) }}">
                                                                <i class="far fa-user"></i>
                                                                {{ $category_news_data->user->name['np'] }}
                                                            </a>
                                                        @endif
                                                    </li>
                                                    <li><i class="far fa-clock"></i>
                                                        {{ published_date($category_news_data->published_at) }}</li>
                                                </ul>

                                            </div>

                                            <div class="details-share-right">
                                                <div class="details-share-right1">


                                                </div>
                                                <p>
                                                    {{-- {!! str_limit(strip_tags($category_news_data->description['np']),400) !!} --}}
                                                   {{strip_tags(parse_description($category_news_data, false, 400))}}
                                                </p>
                                            </div>
                                        </div>
                                        {{-- @endif --}}
                                @endforeach
                            @endif
                        </div>
                    </article>


                    <div class="aside-news mt">
                        <div class="row">
                            @if (isset($section1) && $section1->count())
                                @foreach ($section1 as $key => $category_news_data)
                                    {{-- @if ($loop->iteration > 1 && $loop->iteration <= 4) --}}
                                    <div class="col-lg-4 col-md-6">
                                        <div class="bank-sec-wrap">
                                            <div class="bank-img">
                                                <x-shared-image
                                                    newsimage="{{ create_image_url($category_news_data->img_url, 'medium_large') }}"
                                                    title="{{ @get_title($category_news_data) }}" />
                                                {{-- <img src="{{ create_image_url($category_news_data->img_url, 'medium_large') }}" --}}
                                                {{-- class="img-responsive"> --}}


                                                {{-- <a href="{{ route('newsDetail', $category_news_data->slug) }}" --}}
                                                {{-- class="category-tag"> --}}
                                                {{-- @if (isset($categoryInfo)) --}}
                                                {{-- {{ @get_title($categoryInfo) }} --}}
                                                {{-- @else --}}
                                                {{-- {{app()->getLocale() == 'np'? 'क्यापिटल विशेष':'Capital Bishesh'}} --}}
                                                {{-- @endif --}}
                                                {{-- </a> --}}

                                            </div>
                                            <div class="bank-content">
                                                <h2><a
                                                        href="{{ route('newsDetail', $category_news_data->slug) }}">{!! @get_title($category_news_data) !!}</a>
                                                </h2>
                                                <span class="thumb-time"><i class="far fa-clock"></i>
                                                    {{ published_date($category_news_data->published_at) }}</span>
                                                <p>
                                                    {!! strip_tags(parse_description($category_news_data, false, 200)) !!}

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
                                                        <x-shared-image
                                                            newsimage="{{ create_image_url($category_news_data->img_url, 'medium_large') }}"
                                                            title="{{ @get_title($category_news_data) }}" />
                                                        {{-- <img src="{{ create_image_url($category_news_data->img_url, 'medium_large') }}" --}}
                                                        {{-- class="img-responsive"> --}}

                                                        {{-- <a href="{{ route('newsDetail', $category_news_data->slug) }}" --}}
                                                        {{-- class="category-tag"> --}}
                                                        {{-- @if (isset($categoryInfo)) --}}
                                                        {{-- {{ @get_title($categoryInfo) }} --}}
                                                        {{-- @else --}}
                                                        {{-- {{app()->getLocale() == 'np'? 'क्यापिटल विशेष':'Capital Bishesh'}} --}}
                                                        {{-- @endif --}}
                                                        {{-- </a> --}}

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
                                                            {!! strip_tags(parse_description($category_news_data, false, 200)) !!}

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
                                            <div class="bank-img">
                                                <x-shared-image
                                                    newsimage="{{ create_image_url($category_news_data->img_url, 'medium_large') }}"
                                                    title="{{ @get_title($category_news_data) }}" />
                                                {{-- <img src="{{ create_image_url($category_news_data->img_url, 'medium_large') }}" --}}
                                                {{-- class="img-responsive"> --}}

                                                {{-- <a href="{{ route('newsDetail', $category_news_data->slug) }}" --}}
                                                {{-- class="category-tag"> --}}
                                                {{-- @if (isset($categoryInfo)) --}}
                                                {{-- {{ @get_title($categoryInfo) }} --}}
                                                {{-- @else --}}
                                                {{-- {{app()->getLocale() == 'np'? 'क्यापिटल विशेष':'Capital Bishesh'}} --}}
                                                {{-- @endif --}}
                                                {{-- </a> --}}

                                            </div>
                                            <div class="bank-content">
                                                <h2><a
                                                        href="{{ route('newsDetail', $category_news_data->slug) }}">{!! @get_title($category_news_data) !!}</a>
                                                </h2>
                                                <span class="thumb-time"><i class="far fa-clock"></i>
                                                    {{ published_date($category_news_data->published_at) }}</span>
                                                <p>
                                                    {!! strip_tags(parse_description($category_news_data, false, 200)) !!}

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
                                                        newsimage="{{ create_image_url($category_news_data->img_url, 'medium_large') }}"
                                                        title="{{ @get_title($category_news_data) }}" />
                                                    {{-- <img --}}
                                                    {{-- src="{{ create_image_url($category_news_data->img_url, 'medium_large') }}"> --}}
                                                </a>

                                                {{-- <a href="{{ route('newsDetail', $category_news_data->slug) }}" --}}
                                                {{-- class="category-tag"> --}}
                                                {{-- @if (isset($categoryInfo)) --}}
                                                {{-- {{ @get_title($categoryInfo) }} --}}
                                                {{-- @else --}}
                                                {{-- {{app()->getLocale() == 'np'? 'क्यापिटल विशेष':'Capital Bishesh'}} --}}
                                                {{-- @endif --}}
                                                {{-- </a> --}}
                                            </div>
                                            <div class="news-text">
                                                <h2>
                                                    <a href="{{ route('newsDetail', $category_news_data->slug) }}">
                                                        {!! @get_title($category_news_data) !!}
                                                    </a>
                                                </h2>
                                                <span class="thumb-time">
                                                    <i class="far fa-clock"></i>
                                                    {{ published_date($category_news_data->published_at) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @endif --}}
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="paginations">
                        {{ $category_news->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @else
                <h3>कुनै समाचार छैन!!!</h3>
            @endif
        </div>
    </section>
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
