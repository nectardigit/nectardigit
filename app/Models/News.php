<?php

namespace App\Models;

use App\Models\Menu;

use App\Models\User;
use App\Models\NewsGuest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class News extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'title',
        'summary',
        'description',
        'category',
        'reporters',

        'tags',

        "slug",
        "news_language",
        "reporter",
        "publish_status",
        "postType",
        "guest",
        "guestId",
        'view_count',
        'text_position',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_keyphrase',
        "created_by",
        "oldId",
        "isOldData",
        "isBanner",
        "img_url",

        "folder_path",
        "updated_by",


        "feature_img_url",
        "published_at",
        'mobile_notifications',
        'isSpecial',
        'image_caption',
        'showReporter',
        'showContent',
        'isFlashNews',
        'flashNewsOrder',
        'isVideo',
        'isFixed',
        'isBreaking',
        "breakingNewsOrder",
        "tagLine",
        "byLine",
        "userId",
        "video",
        "image",
        'isPhotoFeature',
        'image_show',
        "publish",
        "subtitle"
    ];
    protected $dates = ['deleted_at', 'published_at'];
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
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
        "reporters" => "json",
        'published_at' => 'dateTime'

    ];
    // public function setCategory()
    // {
    //     return json_decode($this->category, true);
    // }
    public function user()
    {
        return $this->belongsTo(User::class, "created_by");
    }
    public function updatedUser(){
        
        return $this->belongsTo(User::class, "updated_by");

    }
    public function reporters()
    {
        return $this->belongsTo(User::class, "reporter");
    }
    public function guests()
    {
        return $this->belongsTo(NewsGuest::class, "guestId");
    }
    public function get_news_reporter()
    {
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId');
    }
    public function news_reporter()
    {
        return $this->hasOne('App\Models\Profile', 'user_id', 'reporter')->withTimestamps();
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

    public function get_category()
    {
        //    return $this->hasMany(Menu::class,"news_categories","newsId","id");
        return $this->hasManyThrough(Menu::class, NewsCategory::class, "categoryId", "id",  'id', 'id')->withTimestamps();;
    }


    public function newsHasCategories()
    {
        return $this->belongsToMany(Menu::class, 'news_categories', 'newsId', 'categoryId')->withTimestamps();;
        //first argument  => class of table by relation
        // second argument => pivot table by this class and first agrument table
        // Third argument  => relation key of this model
        // Fourth argument  => relation key of  first argument class table
    }
    public function newsHasTags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags', 'newsId', 'tagId')->withTimestamps();;
    }
    public function advertisements()
    {
        return $this->belongsToMany(Menu::class, 'news_categories', 'newsId', 'categoryId');
        return $this->hasMany('App\Models\Advertisement');
    }
    public function scopeVerifiednews($query)
    {
        return $query->where('published_at', '<', Carbon::now())->where('deleted_at', null)->where('publish_status', '1');
    }
    public function newsHasAddToReadNews()
    {
        return $this->belongsToMany(News::class, AddToReadThisNews::class, "newsId", "addedNewsId");
    }
    public function getReporter()
    {
        return $this->belongsTo(User::class, 'reporter');
    }
    public function newsReporters()
    {
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId')->withTimestamps();;
    }
    public function setPublishedAtAttribute($value)
    {
        if (empty($value)) {
            $data = Carbon::now();
            $this->attributes['published_at'] = $data->format('Y-m-d H:i:s');
            $this->attributes['publish'] = $data->timestamp;
        } else {
            $data = Carbon::parse($value);
            $this->attributes['published_at'] = $data->format('Y-m-d H:i:s');
            $this->attributes['publish'] = $data->timestamp;
        }
    }
    public function newsHasReporter()
    {
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId')->withTimestamps();;
    }
    public function news_reporters()
    {
        return $this->belongsToMany(Reporter::class, NewsReporter::class, 'newsId', 'reporterId');
    }
}
