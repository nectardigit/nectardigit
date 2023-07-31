<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoroscopeCategory extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'subTitle', 'logo_url'];
    protected $casts = [
        'title' => 'json',
    ];
}
