<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class BreakingNewsController extends Controller
{
    //
    public function __construct(News $news )
    {
        $this->news = $news;
    }

    public function breakingNews(Request $request){
        $userRole = request()->user()->roles->first()->name;

        $limit = 10;
        if ($request->limit && $request->limit > 0 && $request->limit < 150) {
            $limit = $request->limit;
        }
        $this->news = $this->news->query()->where('isBreaking','1');

        // dd($news);
        if ($request->status == '1') {
            $news = $this->news->where('publish_status', '1');
        } elseif ($request->status == '0') {
            $news = $this->news->where('publish_status', '0');
        } else {
            $news = $this->news;
        }

        $news = $news
            // ->select('id', 'title', 'thumbnail', 'path', 'publish_status')
            ->when($request->keyword, function ($qr) use ($request,$userRole) {
                if ($userRole == 'Super Admin' || $userRole == 'Admin') {
                return $qr->where('title', 'like', "%$request->keyword%")
                    ->orWhere('description', 'like', "%$request->keyword%")
                    ->orWhere('oldId', 'like', "%$request->keyword%");
                }
                else{
                    return $qr->where('created_by', auth()->user()->id)
                    ->where('title', 'like', "%$request->keyword%");
                //     ->orWhere(function($query) use ($request) {
                //         $query->where('title', 'like', "%$request->keyword%")
                //               ->where('description', 'like', "%$request->keyword%");

                //     })
                }
            })
            ->with([
                'newsHasTags', 'getreporter:id,name',
                'newsHasCategories' => fn ($qr) => $qr->select('news_categories.id', 'menus.title', 'newsId', 'categoryId')
            ])
            ->where(function ($qr) use ($userRole) {
                // dd($userRole);
                if ($userRole != 'Super Admin' && $userRole != 'Admin') {
                    return $qr->where('created_by', auth()->user()->id);
                }
            })
            ->orderBy('created_at', 'DESC')
            // ->orderBy('id', 'DESC')
            ->paginate($limit);
        $news->appends($request->all());
        // dd($news);
        $data = [
            'news' => $news,
            'pageTitle' => "Breaking News",
        ];
        return view('admin/news/news-list', $data);
        // return $news;
    }
}
