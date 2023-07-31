<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsGuest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'position',
        'publish_status',
        'created_by',
        'image',
        "path",
        'organization',
        'contact_no',
        'slug_url', 
        'facebook',
        'address',
        'email',
        
        'guest_description',
        "guest_caption",
        'slug',
        'twitter',
        
        "oldId",
        "isOldData",
      
 
    ];
    protected $casts = [
        'name' => "json",
        "position" => "json",
        "organization" => "json",
    ];
    protected $dates = ['deleted_at'];
}
