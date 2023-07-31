<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\News;

class FrontTagController extends Controller
{
    public function __construct(News $news, Tag $tag)
    {
        $this->news = $news;
        $this->tag = $tag;
    }
    public function getTagNews($slug){
        // dd($slug);
        $tag = $this->tag->where('slug',$slug)->first();
        if(!$tag){
            abort(404);
        }
        $tag_news = $tag->tagNews()
        ->select(
            'category',
            'description',
            'news_language',
            'title',
            'slug',
            'published_at',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
            'img_url'
        )->orderBy('published_at', 'DESC')->paginate(15);
        $data = [
            'tag' => $tag,
            'tag_news' => $tag_news,
        ];
        if ($tag_news->count()) {
            $data['banner_news'] = @$tag_news->take(1);
            $data['section1'] = @$tag_news->skip(1)->take(3);
            $data['section2'] = @$tag_news->skip(3)->take(2);
            $data['section3'] = @$tag_news->skip(6)->take(3);
            $data['section4'] = @$tag_news->skip(9)->take(6);
            // $data['meta'] = $this->getMetaData($data['banner_news']);
        }
        // dd($data);

        return view('website/news/tag-news-list', $data);

    }
}
