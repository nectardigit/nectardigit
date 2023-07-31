<section class="related-news pt pb">
    {{-- {{dd($related_news)}} --}}
    @if(isset($related_news) && $related_news->count())
        <div class="container">
            <div class="global-title">
                <h3>सम्बन्धित समाचार</h3>
                
                <a href="{{route('getRelatedNews',$news_detail->slug)}}" title="">सबै <i class="fas fa-angle-right"></i></a>
            </div>
    
    
            @if($is_news_loaded)
            <div class="row">
                @isset($related_news)
                    @foreach ($related_news as $key => $news_data)
                        <div class="col-lg-4 col-md-6">
                            <div class="thumb-news">
                                <div class="left-img">
                                    <a href="{{ route('newsDetail', $news_data->slug) }}">
                                       
                                        <img src="{{ create_image_url($news_data->img_url, 'thumbnail') }}"
                                            title="{{ @get_title($news_data) }}" alt="{{ $news_data->thumbnail }}">
                                    </a>
                                </div>
                                <div class="news-text">
                                    <h2>
                                        <a href="{{ route('newsDetail', $news_data->slug) }}">
                                            {{ @get_title($news_data) }} </a>
                                    </h2>
                                    <span class="thumb-time">
                                        <i class="far fa-clock"></i> {{ published_date($news_data->created_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
            @endif 
        </div>
    @endif
    </section>
    
