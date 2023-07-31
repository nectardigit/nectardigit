<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Blog extends Model
{
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->slug,
            'title' => $this->title,
            'summary' => $this->description,
            'updated' => $this->updated_at,
            'link' => route('page',$this->slug),
            'authorName' => 'Nectar Digit',
        ]);
    }
    public static function getFeedItems()
    {
        $blog=DB::table('blogs')->select('blogs.*')->get();
        // dd($blog[0]);
        return $blog;
    }

    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'featured_image',
        'parallax_image',
        'slug',
        'publish_status',
        'display_home',
        'postType',
        'view_count',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_keyphrase',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag', 'blog_id', 'tag_id')->withTimestamps();
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, 'blog_categories', 'blog_id', 'category_id');
    }
    public function publisher(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
