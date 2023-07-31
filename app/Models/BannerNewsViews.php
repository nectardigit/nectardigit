<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerNewsViews extends Model
{
    use HasFactory;
    protected $table = 'banner_news_views';
    protected $casts =
    [
        'title' => 'json',
        'description'=>'json',
        'published_at'=>'dateTime'
    ];

    public function newsHasReporter()
    {
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId')->withTimestamps();;
    }
    public function news_reporters()
    {
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId');
    }

    public function newsHasTags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags', 'newsId', 'tagId')->withTimestamps();;
    }
}
