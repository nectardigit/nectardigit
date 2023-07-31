<?php

namespace App\Models;

use App\Traits\DatabaseUpdater\BindDynamicTableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalDatabaseConnection extends Model
{
    protected $connection = "mysql2";
    protected $table  = null; 
    use BindDynamicTableModel;
    use HasFactory;
}
