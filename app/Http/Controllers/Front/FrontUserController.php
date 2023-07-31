<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;

class FrontUserController extends Controller
{
    public function __construct(News $news, User $user)
    {
        $this->news = $news;
        $this->user = $user;
    }
    public function getUser(Request $request , $slug = null){
        $reporter = $this->user->where('slug', $slug)
        ->select('id','name')

        ->first();
        if($reporter){
            $data = [
                'reporter_detail' => $reporter,
            ];
        // dd($reporter);

        $reporter_news = $this->news->select('id','category','description','title','slug','created_at','published_at','img_url')
        ->where('created_by',$reporter->id)->orderBy('published_at', 'DESC')->paginate(18);
        $data['reporter_news'] = $reporter_news;
        if($reporter_news->count()){
            $data['section1'] = @$reporter_news->take(3);
            $data['section2'] = @$reporter_news->skip(3)->take(2);
            $data['section3'] = @$reporter_news->skip(5)->take(3);
            $data['section4'] = @$reporter_news->skip(8)->take(6);
        }
        // dd($data);
        return view('website.news.reporter-news-list',$data);


        }
        if(!$reporter){
            abort(404);
        }


    }
}
