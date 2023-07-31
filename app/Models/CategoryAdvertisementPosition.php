<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAdvertisementPosition extends Model
{
    use HasFactory;
    protected $fillable = [
        'adPositionId',
        "categoryId"
    ];
}
