<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Team extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'full_name' => 'json',
        'description' => 'json',
    ];
    protected $fillable = [
        'full_name',
        'image',
        'phone',
        'address',
        'email',
        'view_count',
        'twitter',
        'facebook',
        'description',
        'created_by',
        'updated_by',
        'oldId',
        'isOldData',
        'publish_status',
        'show_footer',
        'designation_id',
        'instagram',
        'youtube',
        'slug',
    ];
    protected $dates  = ['deleted_at'];

    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }

}
