<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'slug',
        'short_description',
        'date',
        'display_home',
        'develop_by',
        'client_name',
        'image',
        'logo',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_keyphrase',
        'url',
        'position',
        'view_count',
        'publish_status',
        'created_by',
        'updated_by',
    ];
    protected $dates  = ['deleted_at'];

}
