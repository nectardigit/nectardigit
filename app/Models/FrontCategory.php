<?php

namespace App\Models;

use App\Models\News;
use App\Models\AdvertisementPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class FrontCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'menus';
    // protected $appends = ['category_news'];
    protected $fillable = [
        'title',
        'content',
        'slug',
        "oldId",
        'external_url',
        'position',
        "side_position",
        'parent_id',
        'publish_status',
        'short_description',
        'description',
        'featured_img',
        'parallex_img',
        'created_by',
        'updated_by',
        'meta_title',
        'meta_keyword',
        'meta_description',
        "meta_keyphrase",
        "featured_img_path",
        "parallex_img_path",
        "content_type",
        "show_on",
        "oldId",
        "isOldData",
        "news_section"
    ];
    protected $casts = [
        'title' => "json",
        'short_description' => "json",
        'description' => "json",
        'show_on' => "json",
    ];
    protected $dates = ['deleted_at'];
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
    public function child_menu()
    {
        return $this->hasMany(FrontCategory::class, 'parent_id', 'id')->orderby('position', 'asc');
    }

    public function getRules($act = 'add', $id = null)
    {
        $rules = [
            'title' => 'required|string',
            'slug' => 'required|unique:menus,slug|string',
            'status' => 'required|in:active,inactive',
            'publish_status' => 'required|in:1,0',
        ];
        if ($act == 'update') {
            $rules['slug'] = 'nullable|string|unique:menus,slug,' . $id;
        }
        return $rules;
    }
    public function setCategory()
    {
        return json_decode($this->id, true);
    }
    public function regex()
    {
        return '/^[a-zA-Z0-9](.*[a-zA-Z0-9])?$/';
    }
    public function news()
    {
        // return $this->hasMany(News::class, 'category->*', 'id');
        return $this->hasManyThrough(News::class, NewsCategory::class, "categoryId", "id",  'id', 'id');
    }
    public function categoriesHasNews()
    {
        return $this->belongsToMany(News::class, NewsCategory::class, 'categoryId', 'newsId');
        //first argument  => class of table by relation
        // second argument => pivot table by this class and first agrument table
        // Third argument  => relation key of this model
        // Fourth argument  => relation key of  first argument class table
    }
    public function categoriesHasAdvertisementPosition()
    {
        return $this->belongsToMany(AdvertisementPosition::class, CategoryAdvertisementPosition::class, "categoryId", "adPositionId");
    }
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'section');
    }

    public function advertisementPositions()
    {
        return $this->hasMany(AdvertisementPosition::class, 'section');
    }


    protected $news_fields = [
        "news.id",
        "news.title",
        "news.summary",
        "news.description",
        "news.isBanner",
        "news.slug",
        "news.guestId",
        "news.text_position",
        "news.img_url",


        "news.feature_img_url",
        "news.published_at",
        "news.created_at",
    ];
    // public function getCategoryNewsAttribute()
    // {
    //     return $this->categoriesHasNews()->select($this->news_fields)
    //         ->where('publish_status', '1')
    //         ->where('categoryId', $this->id)
    //         ->orderBy('news.created_at', 'DESC')
    //         ->limit(8)
    //         ->get();
    // }

}
