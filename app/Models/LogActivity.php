<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    public function log_by(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
    protected $fillable = ['subject', 'url', 'method', 'ip', 'agent', 'user_id'];
    use HasFactory;
}