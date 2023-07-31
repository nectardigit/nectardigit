<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporter extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'facebook',
        'phone',
        'twitter',
        'address',
        'image',
        'slug_url',
        "oldId",
        "isOldData",
        'designation',
        'profile_image_url',
        "description",
        "caption",
        "publish_status",
        'slug',
        // "caption",
        "name",
        "email",
        "allow_to_login",
        "created_by",
        "updated_by",

    ];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'name' => "json",
    ];
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function reportersNews()
    {
        return $this->belongsToMany(News::class, NewsReporter::class, 'reporterId', 'newsId');
        //first argument  => class of table by relation
        // second argument => pivot table by this class and first agrument table
        // Third argument  => relation key of this model
        // Fourth argument  => relation key of  first argument class table
    }
    public function getReporterNewsAttribute()
    {
        return $this->reportersNews()->count();
    }
    public function getPublishedNewsAttribute()
    {
        return $this->reportersNews()->where('publish_status', '1')->count();
    }
    public function getUnpublishedNewsAttribute()
    {
        return $this->reportersNews()->where('publish_status', '0')->count();
    }
}
