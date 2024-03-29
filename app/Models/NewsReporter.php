<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsReporter extends Model
{
    use HasFactory;
    protected $fillable = [
        'newsId',
        "reporterId",
        "oldId"
    ];
}
