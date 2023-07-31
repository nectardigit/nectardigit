<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsGuest;
use App\Models\News;

class FrontGuestController extends Controller
{
    public function __construct(News $news, NewsGuest $guest)
    {
        $this->news = $news;
        $this->guest = $guest;
    }
    public function getGuest(Request $request, $slug = null){
        // dd($slug);
        $guest = $this->guest->where('slug_url',$slug)->select('id','slug','name','image','facebook')->first();
        if(!$guest){
            abort(404);
        }

        $data = [
            'guest_detail' => $guest,
        ];

        if (!empty($guest)) {
            $data = [
                'guest_detail' => $guest,
            ];
            $guest_news = $this->news
                ->select('id','description', 'category', 'img_url',   'title', 'slug', 'created_at')
                ->where('publish_status', '1')
                ->where('guestId', $guest->id)
                ->orderBy('published_at', 'DESC')
                ->paginate(14)->appends($request->all());
            $data['guest_news'] = $guest_news;
            if($guest_news->count()){
                $data['section1'] = @$guest_news->take(3);
                $data['section2'] = @$guest_news->skip(3)->take(2);
                $data['section3'] = @$guest_news->skip(5)->take(3);
                $data['section4'] = @$guest_news->skip(8)->take(6);
            }
        }
        // dd($data);
        return view('website.news.guest-news-list',$data);

    }

}
