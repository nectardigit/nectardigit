<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'publish_status',
        'position',
        'description',
        'image',

    ];
    protected $dates  = ['deleted_at'];
}
