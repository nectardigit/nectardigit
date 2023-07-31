<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use NewsItem;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;


class BlogFeed extends Blog implements Feedable
{
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->slug,
            'title' => $this->title,
            'summary' => $this->description,
            'updated' => $this->updated_at,
            'link' => route('detailpage',$this->slug),
            // 'authorName' => $this->authorName,NewsItem
        ]);
    }
    public static function getFeedItems()
    {
        return Blog::where('publish_status','1')->orderby('id','DESC')->get();
    }
}
