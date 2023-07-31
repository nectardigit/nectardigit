<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontNews extends Model
{
    // use SoftDeletes;
    // use HasFactory;
    protected $table = 'news';
    protected $dates = ['deleted_at', 'published_at'];
    protected $casts = [
        'title' => "json",
        'summary' => "json",
        'description' => "json",
        'tags' => "json",
        'category' => "json",
        "guest" => "json",
        "feature_img" => "array",
        "feature_img_url" => "array",
        "feature_img_path" => "array",
        "feature_img_url" => "array",
    ];
    public function newQuery()
    {
        return parent::newQuery()
        ->where('news.deleted_at', null)
            ->where('news.publish_status', '1');
            // ->where('news.published_at', '<=', now());
        // ->orderBy('id', 'desc');
        // ->orderBy('published_at', 'DESC');
    }
    public function reporters()
    {
        return $this->belongsTo(Reporter::class, "reporter");
    }
    public function guests()
    {
        return $this->belongsTo(NewsGuest::class, "guestId");
    }

    public function news_reporter()
    {
        return $this->hasOne('App\Models\Reporter', 'user_id', 'reporter');
    }

    public function news_guest()
    {
        return $this->hasOne('App\Models\NewsGuest', 'id', 'guestId');
    }

    public function categoryList($ids)
    {
        if ($ids && is_array($ids)) {
            return Menu::whereIn('id', $ids)->select('title', 'id')->get();
        }
        return false;
    }
    public function tagList($ids)
    {
        if ($ids && is_array($ids)) {
            return Tag::whereIn('id', $ids)->select('title', 'id')->get();
        }
        return false;
    }

    // public function get_category()
    // {
    //     return $this->hasMany('App\Models\Menu', 'id', 'category->*');
    // }
    public function news_categories()
    {
        return $this->hasMany(NewsCategory::class, 'newsId');
    }
    public function get_category()
    {
        //    return $this->hasMany(Menu::class,"news_categories","newsId","id");
        return $this->hasManyThrough(Menu::class, NewsCategory::class, "categoryId", "id", 'id', 'id');
    }

    public function newsHasCategories()
    {
        return $this->belongsToMany(Menu::class, 'news_categories', 'newsId', 'categoryId');
        //first argument  => class of table by relation
        // second argument => pivot table by this class and first agrument table
        // Third argument  => relation key of this model
        // Fourth argument  => relation key of  first argument class table
    }
    public function newsHasTags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags', 'newsId', 'tagId');
    }
    public function advertisements()
    {
        return $this->belongsToMany(Menu::class, 'news_categories', 'newsId', 'categoryId')->where('advertisements.publish_status', '1');
        // return $this->hasMany('App\Models\Advertisement');
    }
    public function newsHasAddToReadNews()
    {
        return $this->belongsToMany(News::class, AddToReadThisNews::class, "newsId", "addedNewsId");
    }
    public function getReporter()
    {
        return $this->belongsTo(Reporter::class, 'reporter');
    }
    public function user()
    {
        return $this->belongsTo(User::class, "created_by");
    }
    public function setPublishedAtAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['published_at'] = now()->format('Y-m-d H:i:s');
        } else {
            $this->attributes['published_at'] = Carbon::parse($this->value)->format('Y-m-d H:i:s');
        }
    }
    public function scopeVerifiednews($query)
    {
        return $query
        // ->where('publish_status', '1')
        // ->where('deleted_at', null)
        ->where('published_at', '<', now());
    }
    // public function get_reporters()
    // {
    //     return $this->hasManyThrough(Reporter::class, NewsReporter::class, "newsId", "reporters",  'id', 'id');
    // }
    public function news_reporters()
    {
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId');
        // return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId');
    }
    public function reporters_info(){
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId');
    }
}
