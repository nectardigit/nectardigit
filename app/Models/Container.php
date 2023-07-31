<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'title',
        'type',
        'description',
        'icon',
        'image',
        'position',
        'publish_status',
        'created_by',
        'updated_by',
    ];
    protected $dates  = ['deleted_at'];
}
