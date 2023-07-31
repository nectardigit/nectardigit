<table class="table table-bordered">
    <thead>
        <th>#</th>
        <th>News Title</th>
        <th>Published Date </th>
    </thead>
    <tbody>
        @if (isset($news_items) && $news_items->count())
            @foreach ($news_items as $key => $newsItem)
                <tr>
                    <td>{!! Form::checkbox('addtoreadnews[]', $newsItem->id, @$update ?? false, []) !!}</td>
                    <td>{!! @get_title($newsItem) !!}</td>
                    <td>{{ @published_date($newItem->created_at) }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if (!isset($update))
    {{-- {{ @$news_items->links() }} --}}
@endif
