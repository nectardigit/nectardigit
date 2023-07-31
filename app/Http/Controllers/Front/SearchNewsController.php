<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Menu;
use App\Models\User;
use App\Traits\SharedTrait;




use Illuminate\Http\Request;

class SearchNewsController extends Controller
{
    use SharedTrait;
    public $categoryKey = ['menus.id', 'menus.title', 'menus.slug', 'newsId', 'categoryId' ];
    public function __construct(News $news, Menu $category, User $reporter)
    {
        $this->news = $news;
        $this->category = $category;
        $this->reporter = $reporter;
    }

    public function searchNews(Request $request)
    {
        $news = News::where('publish_status', '1')->when($request->keyword, function ($qr) use ($request) {
            $qr->where('title', 'like', "%$request->keyword%")
                ->orWhere('description', 'like', "%$request->keyword%");
        })
            ->when($request->f, function ($qr) use ($request) {
                $start_date = $request->f ? date('Y-m-d 00:00:00', strtotime($request->f)) : date('Y-m-d');
                $end_date = $request->t ? date('Y-m-d 23:59:59', strtotime($request->t)) : date('Y-m-d');
                $qr->whereBetween('published_at', [$start_date, $end_date]);
            })
            // ->with(['newsHasCategories'])
            ->orderBy('published_at', 'DESC')
            ->paginate(21)->appends($request->all());
        // dd($news);
        $data = [
            'news' => $news,
        ];
        // dd($categories);
        return view('website.news.search-result', $data);
    }
}
