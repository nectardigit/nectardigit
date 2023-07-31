@if(isset($add_to_read_news) && $add_to_read_news->count())
<div class="add_to_read_news">
    <h4><strong>यो पनि पढ्नुहोस</strong></h4>
    <ul>
        @foreach($add_to_read_news as $key => $newsItem)
        <li>
            <a href="{{ route('newsDetail', $newsItem->slug) }}" class="nav-link">{{ @get_title($newsItem) }}</a>
        </li>
        @endforeach
    </ul>
</div>
   
@endif