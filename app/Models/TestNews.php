<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestNews extends Model
{
    use HasFactory;
    protected $table = 'news_categories';

    // use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    protected $visible = ['id', 'categoryId', 'newsId', 'created_at', 'updated_at', 'get_news'];
    public function get_news(){
        return $this->hasOne("App\Models\News", 'id', 'newsId') ;
    }
}
