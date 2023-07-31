<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'image',
        'type',
        "user_type",
        'description',
        "oldId",
        "isOldData",
        'extra_data',
        'slug',
        'external_url',
        'seen_status',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'extra_data' => 'json'
    ];
    public function get_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
