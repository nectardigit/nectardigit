<div class="author-sec">
    <div class="author-sec-wrap">
        <div class="author-sec-img">
            {{-- {{ dd($news_detail) }} --}}
            <a href="{{ route('index') }}">
                @if (isset($news_detail->news_guest))
                    <x-shared-image
                        newsimage="{{ create_image_url(@$news_detail->news_guest->image, 'thumbnail') }}"
                        title="{{ @$news_detail->news_guest->name['np'] }}" />

                @elseif (isset($news_detail->news_reporters) &&
                    $news_detail->news_reporters->count() > 1)

                    <x-shared-image
                        newsimage="{{ create_image_url(@$website->favicon, 'logo_small') }}"
                        title="reporter" />

                @elseif (isset($news_detail->news_reporters) &&
                    $news_detail->news_reporters->count() == 1)

                    <x-shared-image
                        newsimage="{{ reporter_img_url(@$news_detail->news_reporters->first()->profile_image_url, 'thumbnail') }}"
                        title="reporter" />
                @else
                    <x-shared-image
                        newsimage="{{ reporter_img_url(@$website->favicon, 'logo_small') }}"
                        title="logo" />

                @endif
            </a>

            <h3>
                @if (isset($news_detail->news_guest))
                    <h3>
                        <a
                            href="{{ route('getGuest', $news_detail->news_guest->slug_url) }}">{{ @$news_detail->news_guest->name['np'] }}
                        </a>
                    </h3>
                @elseif(isset($news_detail->news_reporters) &&
                    $news_detail->news_reporters->count())
                    @foreach ($news_detail->news_reporters as $key => $reporter)
                        <a href="{{ route('getReporter', @$reporter->slug) }}">
                            {{ get_reporter($reporter) }}</a>
                    @endforeach
                @elseif (!$news_detail->news_reporters->count())
                    <a href="{{ route('getUser', @$news_detail->user->slug) }}">
                        {{ $news_detail->user->name['np'] }}
                    </a>
                @endif
            </h3>
        </div>
        {{-- <div class="author-sec-title">
        @isset($news_detail->news_guest)
        <h3><a href="{{route('getGuest',$news_detail->news_guest->slug_url)}}">{{ @$news_detail->news_guest->name['np'] }}</a></h3>
        @endisset
        {{-- <ul>
                <li class="facebook">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </li>
                <li class="twitter">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </li>
            </ul>
    </div> --}}
    </div>

    @if (isset($reporter_news) && $reporter_news->count())
        <div class="author-sec-content">
            <div class="show-less-text">
                <ul>
                    @foreach ($reporter_news as $key => $reporter_news_data)
                        @if ($loop->iteration <= 5)
                            <li>
                                <a
                                    href="{{ route('newsDetail', $reporter_news_data->slug) }}">
                                    {{ @$reporter_news_data->title['np'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @if (count($reporter_news) > 5)
                    <div id="show-more"><a href="javascript:void(0)">थप हेर्नुहोस</a></div>
                @endif
            </div>
            <div id="show-more-content">
                <ul>
                    @foreach ($reporter_news as $key => $reporter_news_data)
                        @if ($loop->iteration > 5)
                            <li>
                                <a
                                    href="{{ route('newsDetail', $reporter_news_data->slug) }}">
                                    {{ @$reporter_news_data->title['np'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                </ul>
                <div id="show-less"><a href="javascript:void(0)">कम हेर्नुहोस</a></div>
            </div>
        </div>
    @endif
</div>
