<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
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
        'img_path',
        'img_extension',
        'img_name',
        'img_url',
        'folder_path',
        'thumbnail',
        'path',
    ];
    protected $dates = ['deleted_at'];
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
