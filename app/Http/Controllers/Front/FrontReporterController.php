<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Reporter;
use App\Models\User;
use App\Models\News;

class FrontReporterController extends Controller
{
    public function __construct(News $news, Reporter $reporter)
    {
        $this->news = $news;
        $this->reporter = $reporter;
    }
    public function getReporter(Request $request, $slug = null)
    {
        $reporter = $this->reporter->where(function ($qr) use ($slug) {
            return $qr->where('slug', $slug)
                ->where('slug', $slug);
        })
            ->select('id', 'name', 'profile_image_url', 'twitter', 'facebook')
            // ->with([
            //     'reportersNews' => fn($qr) => $qr->select('*')->paginate(14),
            // ])
            ->first();
        if (!$reporter) {
            abort(404);
        }
        if ($reporter) {
            $data = [
                'reporter_detail' => $reporter,
            ];
            $reporter_news = $reporter->reportersNews()->orderBy('published_at', 'DESC')->paginate(14);
            $data['reporter_news'] = $reporter_news;
            if ($reporter_news->count()) {
                $data['section1'] = @$reporter_news->take(3);
                $data['section2'] = @$reporter_news->skip(3)->take(2);
                $data['section3'] = @$reporter_news->skip(5)->take(3);
                $data['section4'] = @$reporter_news->skip(8)->take(6);
            }
            return view('website.news.reporter-news-list', $data);
        }
        // dd($reporter);



    }
}
