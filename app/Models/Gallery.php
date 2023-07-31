<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'gallery_images' => 'array',
    ];

    protected $fillable = [
        'title',
        'publish_status',
        'created_by',
        'updated_by',
        'gallery_images',
        'cover_image',
        'slug',
        'position',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_keyphrase',
    ];
    protected $dates  = ['deleted_at'];
}
