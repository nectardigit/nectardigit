<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'image',
        'slider_type',
        'display_home',
        'external_url',
        'position',
        'publish_status',
        'created_by',
        'updated_by',
    ];
    protected $dates  = ['deleted_at'];

   
}
