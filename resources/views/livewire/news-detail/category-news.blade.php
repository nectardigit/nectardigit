<section class="related-categories mt mb">
    @if($is_news_loaded)
    @if(isset($category_news) && $category_news->count())
    <div class="container">
        <div class="global-title">
            @if(isset($category))
            <h3>{{ @get_title($category) }} बाट थप</h3>
            <a href="{{route('newsCategory',$category->slug)}}" title="">सबै <i class="fas fa-angle-right"></i></a>

            @endif
        </div>

        <div class="row">
            @isset($category_news)
                @foreach ($category_news as $key => $cat_news)
                    <div class="col-md-4">
                        <div class="thumbnail-section">
                            <div class="thumbnail-section-img">
                                <img src="{{ create_image_url($cat_news->img_url, 'feature') }}"
                                    alt="{{ @get_title($cat_news) }}" title="{{ @get_title($cat_news) }}">
                            </div>
                            <div class="thumbnail-section-content">
                                <h3>
                                    <a href="{{ route('newsDetail', $cat_news->slug) }}"
                                        title="{{ @get_title($cat_news) }}">
                                        {{ @get_title($cat_news) }}
                                    </a>
                                </h3>
                                <span class="thumb-time">
                                    <i class="far fa-clock"></i>
                                    {{ @published_date($cat_news->published_at) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>

    @endif
    @endif
</section>
