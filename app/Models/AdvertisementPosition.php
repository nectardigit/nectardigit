<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisementPosition extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'publish_status',
        'key',
        'section',
        'created_by',
        'updated_by',
        'quantity',
        "page"
    ];
    protected $casts = [
        // 'section' => 'json',
        "deleted_at" => "date"
    ];
    public function get_section()
    {
        return $this->hasOne('App\Models\Menu', 'id', 'section');
    }
    public function menuSection($ids)
    {

        return Menu::whereIn('id', $ids)->select('id', 'title')->orderBy('title')->get();
        // return $this->hasOne('App\Models\Menu', 'id', 'section->*');
    }
    public function startup_ad()
    {
        return $this->hasMany("App\Models\Advertisement", 'position', 'id');
    }
    public function content_before_advertise()
    {
        return $this->hasMany("App\Models\Advertisement", 'position', 'id')->with('advertiseHasImage');
    }
    public function content_after_author_advertise(){
        return $this->hasMany("App\Models\Advertisement", 'position', 'id')->with('advertiseHasImage');

    }

}
