<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppNotice extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'image',
        'publish_status',
        'url',
        'from_date',
        'to_date',
        'from_time',
        'to_time',
        'added_by',
        
        "oldId",
        "isOldData",
    ];
}
