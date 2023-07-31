<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedMigrationTableColumn extends Model
{
    use HasFactory;
    protected $fillable = [
        'internal_column',
        'external_column',
        'external_table',
        'internal_table',
        'external_table_id',
        'internal_table_id',
        'created_by',
        'updated_by',
        "is_primary_key"
    ];
}
