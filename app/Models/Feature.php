<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'created_by', 'updated_by', 'slug', 'short_title',
        "oldId",
        "isOldData", 'full_description', 'short_description','icon', 'parallax_image', 'feature_image',  'position', 'publish_status'
    ];
    protected $dates = ['deleted_at'];
}
