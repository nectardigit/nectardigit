<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaLibrary extends Model
{
    use HasFactory;
    protected $fillable = [
        "url",
        "table",
        "contentId",
        "urls",
        "name",
        "extension",
        "path",
        "oldId",
        "isOldData",
        "folder_path"
    ];
}
