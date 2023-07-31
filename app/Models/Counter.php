<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counter extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'happy_client',
        'skil_export',
        'finesh_project',
        'media_post',
        'publish_status',
        'created_by',
        'updated_by',
    ];
    protected $casts  = [
        'happy_client' => 'json',
        'skil_export' => 'json',
        'finesh_project' => 'json',
        'media_post' => 'json',
    ];
    protected $dates  = ['deleted_at'];
}
