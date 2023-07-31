<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Video extends Model
{
    use HasFactory, SoftDeletes;
    // protected $primaryKey = 'id'; // or null

    // public $incrementing = true;
    protected $fillable =
    [
        'title',
        'videoId',
        'url',
        'origin',
        'description',
        'display_home',
        'position',
        'created_by',
        'updated_by',
        "oldId",
        "isOldData",
        "image",
        'publish_status',
    ];
    protected $appends = ['iframe','thumbnail'];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'title' => "json",
        'description' => "json",
    ];

    public function getIframeAttribute()
    {

        if (strtolower($this->origin) == "facebook") {
            $src = "https://www.youtube.com/embed/".$this->videoId;
        }else if (strtolower($this->origin) == "youtube") {
            $src = "https://www.youtube.com/embed/".$this->videoId;

        }else {
            $src = "https://www.youtube.com/embed/".$this->videoId;

        }
        // dd($src);
        return $src;
    }
    public function getVideoUrl($value){
        if (strtolower($value->origin) == "facebook") {
            $src = "https://www.youtube.com/embed/".$value->videoId;
        }else if (strtolower($value->origin) == "youtube") {
            $src = "https://www.youtube.com/embed/".$value->videoId;

        }else {
            $src = "https://www.youtube.com/embed/".$value->videoId;

        }
        return $src;
    }

    public function getThumbnailAttribute(){
        if (strtolower($this->origin) == "facebook") {
            $thumbURL = "http://img.youtube.com/vi/".$this->videoId."/hqdefault.jpg";
        }
        if (strtolower($this->origin) == "youtube") {
            $thumbURL = "http://img.youtube.com/vi/".$this->videoId."/hqdefault.jpg";
        }
       return $thumbURL;
    }
}
