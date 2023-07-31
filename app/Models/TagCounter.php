<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagCounter extends Model
{
    use HasFactory;
    protected $fillable = [
        "newsId",
        "tagId",
        "date",
        "count",
    ];
}
