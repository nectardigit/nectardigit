@extends('layouts.front')
@push('styles')
    {{-- <style>
        .st-custom-button[data-network] {   background-color: #0adeff;   display: inline-block;   padding: 5px 10px;   cursor: pointer;   font-weight: bold;   color: #fff;      &:hover, &:focus {      text-decoration: underline;      background-color: #00c7ff;   }
        </style> --}}
@endpush
@section('page_title',@get_title($news_detail))
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6052e0d61b52e2a6"></script>

    <section class="pfe-details mb">
        <div class="pf-details-banner">
            {{-- {{ dd($news_detail->img_url) }} --}}
            
            <x-shared-image newsimage="{{ create_image_url($news_detail->img_url, 'banner') }}"
                title="{{ @get_title(@$news_detail->title) }}" />
        </div>
        <div class="container">
            <div class="pf-details-wrap">
                <div class="breadcrumbs mb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">होमपेज</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{ route('newsCategory', $category->slug) }}">{{ @get_title($category) }}</a>
                            </li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">
                                <a href="">
                                    {{ @get_title($category) }}
                        </a>
                        </li> --}}
                        </ol>
                    </nav>
                </div>
                <h1>{{ @get_title($news_detail) }}</h1>
                @if (isset($breadcrumb_advertise) && !empty($breadcrumb_advertise))
                    @foreach ($breadcrumb_advertise as $key => $advertise)
                        @include('layouts.advertise-section')
                    @endforeach
                @endif
                <div class="details-share">
                    <div class="details-share-left">
                        <ul>
                            <li>
                                {{-- <a href="{{ route('index') }}">
                            <img class="img-fluid rounded-circle " style="padding:10px;width:70px;height:70px;border-radius:100%;" src="{{ @$sitesetting->logo_url }}" alt="images" />{{ @$sitesetting->name }}

                            </a> --}}
                      
                                <a href="{{ route('index') }}">
                                    <x-shared-image newsimage="{{ $sitesetting->favicon ?  create_image_url($sitesetting->favicon, 'sameimage') : asset('assets\front\images\logo-small.png')}}"
                                        title="logo top" />
                                </a>

                            </li>
                            <li>
                                @if (isset($news_detail) && $news_detail->news_reporters && $news_detail->news_reporters->count())
                                    {{-- <i class="far fa-user"></i> --}}
                                    @foreach ($news_detail->news_reporters as $reporter)
                                        <a target="_blank"
                                            href="{{ route('getReporter', trim($reporter->slug_url)) }}">{{ $reporter->name['np'] }}
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
                    <div class="details-share-right">
                        <div class="details-share-right1">

                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
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
                <div class="pf-details-list">
                    {!! $content !!}
                </div>

                <div class="publish-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ published_date($news_detail->created_at) }} मा प्रकाशित
                </div>

                <div class="comment-section">
                    <div class="comment-title">
                        <h3>प्रतिक्रिया</h3>
                        {{-- <a href="#">3</a> --}}
                    </div>
                    <div id="fb-root" style="width: 100% !important"></div>
                    <script async defer crossorigin="anonymous"
                        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0"></script>

                    <div class="fb-comments" data-width="100%" data-href="{{ URL::current() }}" style="width:100%!important;">
                    </div>
                </div>
            </div>
    </section>

    @livewire('news-detail.photo-feature-related-news', ['news_detail' => $news_detail])

    @livewire('news-detail.photo-feature-category-news', ['news_detail' => $news_detail,'category' => $category])
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
