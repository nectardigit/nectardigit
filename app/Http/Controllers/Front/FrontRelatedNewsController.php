<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrontNews;
use App\Models\FrontCategory;

class FrontRelatedNewsController extends Controller
{
    public function __construct(FrontNews $news, FrontCategory $category)
    {
        $this->news = $news;
        $this->category = $category;
    }

    public function getRelatedNews(Request $request,$slug){
        // dd($slug);
        $news = $this->news->where('slug',$slug)->select('id')->first();
        // $related_news = $this->news
        //         ->select('id', 'title', 'img_url', 'created_at', 'slug', 'category', 'description')
        //     ->where('id', '!=',  $news->id)
        //         ->where(function ($qr) use ($news) {
        //             $iqr = $qr;
        //             foreach ($news->get_category as $key => $cat) {
        //                 if ($cat != $news->category[$key]) {
        //                     $iqr = $iqr->whereJsonContains('category', $cat);
        //                 }
        //             }
        //             return $iqr;
        //         })
        //         ->orderBy('published_at', 'DESC')
        //         ->paginate(21)->appends($request->all());
        $related_news = $this->news->select(
            'news.id',
            'news.title',
            'news.created_at',
            'news.reporter',
            'news.slug',
            'news.description',
            'news.img_url'
        )
            ->leftJoin('news_categories', 'news_categories.newsId', 'news.id')
            ->whereIn('news_categories.categoryId', $news->newsHasCategories->pluck('id'))
            ->orderBy('news.created_at', 'DESC')
            ->where('news.publish_status', '1')
            ->paginate(21)->appends($request->all());;
    // dd($related_news);
    $data = [
        'news' => $related_news,
    ];
    // dd($categories);
    return view('website.news.related-news-list', $data);


    }
}
