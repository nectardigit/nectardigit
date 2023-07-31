<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    use HasFactory;
    public function created_by(){
        return $this->hasOne('App\User','id','added_by');
    }
    public function getRules(){
        return [
            'api'=>'required|url',
            'token'=>'required|string',
            'identity'=>'required|string',
            'status'=>'required|in:1,0',
        ];
    }
    protected $fillable=['api','identity','token','status'];

}
