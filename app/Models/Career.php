<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use HasFactory, SoftDeletes;
    public $guarded = [];
    protected $dates = ['deadLine'];

    public function application()
    {
        return $this->hasMany(Application::class, 'careerId');
    }
}
