<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldDatabase extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'api_url',
        'added_by',
        "aspected_table",
        "framework",
        "content_type",
        'migrated_at',
        'model_name',
    ];
    protected $casts = [
        'migrated_at' => 'dates'
    ];
}
