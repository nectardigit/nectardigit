<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrationAssignedTable extends Model
{
    use HasFactory;
    protected $fillable = [
        "internal_table",
        "external_table",
        "content_type",
        "model_name",
        // "aspected_table",
        "framework",
        "migrated",
        "created_by",
        "updated_by",
        "migrated_by",
        'migrated_at',
    ];
}
