<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'display_home',
        'publish_status',
        'title',
        'description',
    ];

    protected $guarded = [];

}
