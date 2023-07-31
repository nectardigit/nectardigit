<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use SoftDeletes;
    use HasFactory;
    // protected $visible = [
    //     'get_position',
    //     'title',
    //     'organization',
    //     "show_on",
    //     'url',
    //     'position',
    //     "thumbnail",
    //     'tags',
    //     "path",
    //     "publish_status",
    //     "from_date",
    //     "to_date",
    //     "created_by",
    //     "updated_by",
    //     "columnType",
    //     "direction",
    //     "deleted_at", 
    //     "id", 
    //     "created_at",
    //     "updated_at"
    // ];
    protected $fillable = [
        'title',
        'organization',
        "show_on",
        'url',
        'position',
        "thumbnail",
        'tags',
        "path",
        "publish_status",
        "from_date",
        "to_date",
        "created_by",
        "updated_by",
        "columnType",
        "direction",
        "page",
        "section",
        "order",
        "img_url",
        "img_name",
        "img_extension",
        "img_path",
        "folder_path",
        "img_url_app",
        "img_name_app",
        "img_extension_app",
        "img_path_app",
        "folder_path_app",
        "view_count",

        "oldId",
        "isOldData",
    ];

    public function get_position()
    {
        return $this->hasOne('App\Models\AdvertisementPosition', 'id', 'position')
            ->with(['get_section' => fn ($qr) => $qr->select('id', 'title')]);
    }
    public function advertiseHasImage()
    {
        return $this->hasOne('App\Models\MediaLibrary', 'contentId', "id")->where('table', 'advertisements');
    }
}
