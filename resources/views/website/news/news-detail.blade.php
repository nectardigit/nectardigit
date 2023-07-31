@extends('layouts.front')
@section('page_title', @get_title($news_detail))

    @push('styles')
        {{-- <style>
        .st-custom-button[data-network] {   background-color: #0adeff;   display: inline-block;   padding: 5px 10px;   cursor: pointer;   font-weight: bold;   color: #fff;      &:hover, &:focus {      text-decoration: underline;      background-color: #00c7ff;   }
        </style> --}}
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6052e0d61b52e2a6"></script>

    <section class="details-page mt mb">
        <div class="container">
            <div class="row">
                {{-- {{ dd($breadcrumb_advertise) }} --}}
                @if (isset($breadcrumb_advertise) && !empty($breadcrumb_advertise))
                    @foreach ($breadcrumb_advertise as $key => $advertise)
                        @include('layouts.advertise-section')
                    @endforeach
                @endif
            </div>
            {{-- <div class="breadcrumbs mb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('index') }}">होमपेज</a>
                        </li>
                        @if (isset($category))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{ route('newsCategory', $category->slug) }}">{{ @get_title($category) }}</a>
                            </li>

                        @endif
                         
                    </ol>
                </nav>
            </div> --}}
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="details-title">
                        <h1>{{ @get_title($news_detail) }}</h1>
                        <div class="details-share-right">
                            <div class="details-share-right1">

                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                {{-- <ul>
                                    <li class="addthis_inline_share_toolbox">
                                    </li>
                                </ul> --}}
                                <ul>
                                    <div class="sharethis-inline-share-buttons"></div>
                                </ul>
                            </div>
                            <div class="details-share-right2">
                                <ul>
                                    {{-- <li><a href="#">5 प्रतिक्रिया</a></li>
                                <li><b>1089</b> Shares</li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="details-content">
                        <div class="row">
                            {{-- {{dd($after_new_title_ad)}} --}}
                            @if (isset($after_new_title_ad) && !empty($after_new_title_ad))
                                @foreach ($after_new_title_ad as $key => $advertise)
                                    @include('layouts.advertise-section')
                                @endforeach
                            @endif
                        </div>
                        <div class="details-content-img">
                            {{-- <img src="{{ create_image_url($news_detail->img_url, "banner") }}"
                        alt="{{ @get_title(@$news_detail->title) }}"
                        title="{{ @get_title(@$news_detail->title) }}" /> --}}
                            <x-shared-image newsimage="{{ create_image_url($news_detail->img_url, 'banner') }}"
                                title="{{ @get_title(@$news_detail) }}" />
                        </div>
                        <div class="details-content-section">
                            <div id="chcp_font_size" class="input-group">
                                <span class="input-group-btn">
                                    <button id="btn-decrease" class="btn btn-default" type="button">
                                        <i class="fas fa-font" aria-hidden="true"></i>-
                                    </button>
                                    <button id="btn-orig" class="btn btn-default" type="button">
                                        <i class="fas fa-font" aria-hidden="true"></i>
                                    </button>
                                    <button id="btn-increase" class="btn btn-default" type="button">
                                        <i class="fas fa-font" aria-hidden="true"></i>+
                                    </button>
                                </span>
                            </div>
                            <div class="details-share">
                                <div class="details-share-left">
                                    <ul>
                                        <li>
                                            {{-- <a href="{{ route('index') }}">
                                        <img class="img-fluid rounded-circle " style="padding:10px;width:70px;height:70px;border-radius:100%;" src="{{ @$sitesetting->logo_url }}" alt="images" />{{ @$sitesetting->name }}

                                        </a> --}}

                                            @if ($news_detail->news_reporters->count() && $news_detail->news_reporters->count() == 1)
                                                <x-shared-image
                                                    newsimage="{{ reporter_img_url(@$news_detail->news_reporters->first()->profile_image_url, 'thumbnail') }}"
                                                    title="reporter" />
                                            @else
                                                <a href="{{ route('index') }}">
                                                    <x-shared-image
                                                        newsimage="{{ $sitesetting->favicon ? create_image_url($sitesetting->favicon, 'pp_image') : asset('assets\front\images\logo-small.png') }}"
                                                        title="logo top" />
                                                </a>
                                            @endif

                                        </li>
                                        <li>
                                            @if (isset($news_detail) && $news_detail->news_reporters && $news_detail->news_reporters->count())
                                                {{-- <i class="far fa-user"></i> --}}
                                                @foreach ($news_detail->news_reporters as $reporter)

                                                    <a target="_blank" href="{{ route('getReporter', $reporter->slug) }}">
                                                        {{ $reporter->name['np'] }}
                                                    </a>
                                                    {{ !$loop->last ? ',' : '' }}
                                                @endforeach
                                            @elseif (!$news_detail->news_reporters->count())
                                                <a href="{{ route('getUser', @$news_detail->user->slug) }}">
                                                    {{-- <i class="far fa-user"></i> --}}
                                                    {{ $news_detail->user->name['np'] }}
                                                </a>
                                            @endif
                                        </li>


                                    </ul>
                                </div>


                            </div>
                            <div class="change-size">
                                {!! $content !!}
                                <div class="publish-date">
                                    <div class="row mt-3">
                                        <div class="col-12">

                                            <i class="far fa-calendar-alt"></i>
                                            {{ published_date($news_detail->created_at) }} मा प्रकाशित

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- {{dd($news_detail_below_content_ad)}} --}}
                                    @if (isset($news_detail_below_content_ad) && !empty($news_detail_below_content_ad))
                                        @foreach ($news_detail_below_content_ad as $key => $advertise)
                                            @include('layouts.advertise-section')
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- @include('website/news/reaction-section') --}}

                            @include('website.news.news-detail-author-news')
                            <div class="comment-section">
                                <div class="comment-title">
                                    <h3>प्रतिक्रिया</h3>
                                    {{-- <a href="#">3</a> --}}
                                </div>
                                <div id="fb-root"></div>
                                <script async defer crossorigin="anonymous"
                                    src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0"></script>

                                <div class="fb-comments" data-href="{{ URL::current() }}" data-width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- {{dd($content_right_advertise)}} --}}
                <div class="col-lg-4 col-md-12">
                    <div class="details-sidebar">
                        <div class="row">
                            {{-- {{dd($content_right_advertise)}} --}}
                            @if (isset($content_right_advertise) && !empty($content_right_advertise))
                                @foreach ($content_right_advertise as $key => $advertise)
                                    @include('layouts.advertise-section')
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="trending-section">

                        <h3>ट्रेण्डिङ समाचार</h3>
                        <ul>
                            {{-- {{ dd($trending) }} --}}
                            @if (isset($trending) && $trending->count())

                                @foreach ($trending as $key => $trending_data)
                                    <li>
                                        <div class="trending-number">
                                            <span>{{ getUnicodeNumber($key + 1) }}.</span>
                                        </div>
                                        <div class="trending-title">
                                            <a href="{{ route('newsDetail', $trending_data->slug) }}">
                                                {{ @$trending_data->title['np'] }} </a>
                                        </div>
                                    </li>

                                @endforeach
                            @endif
                        </ul>

                    </div>

                    @livewire('news-detail.latest-news' , ['news_detail' => $news_detail])
                </div>
            </div>
        </div>
        </div>
    </section>

    @livewire('news-detail.related-news', ['news_detail' => $news_detail])

    @livewire('news-detail.category-news', ['news_detail' => $news_detail,'category' => $category])
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                Livewire.emit('is_news_loaded');
            }, 100);
        })

    </script>
    {{-- scripts here --}}
@endpush
