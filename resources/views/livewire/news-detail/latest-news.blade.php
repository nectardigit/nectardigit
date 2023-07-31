<div class="trending-section">
@if($is_news_loaded)
    <h3>ताजा समाचार</h3>
    <ul>
        @if (isset($latest_news) && $latest_news->count())

        @foreach ($latest_news as $key => $latest_news_data)
        <li>
            <div class="trending-number">
                <span>{{ getUnicodeNumber($key + 1) }}.</span>
            </div>
            <div class="trending-title">
                <a href="{{ route('newsDetail', $latest_news_data->slug) }}">
                    {{ @$latest_news_data->title['np'] }} </a>
            </div>
        </li>

        @endforeach
        @endif
    </ul>
@endif
</div>