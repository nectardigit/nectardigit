<?php

namespace App\Http\Livewire\NewsDetail;

use App\Models\FrontNews;
use Carbon\Carbon;
use Livewire\Component;

class LatestNews extends Component
{
    public $is_news_loaded = false;
    public $news_detail;
    public $latest_news;
    // public $content_right_advertise;
    public $listeners = ['is_news_loaded' => "loadLatestNews"];

    public function loadLatestNews()
    {
        $this->is_news_loaded = true;
        // dd($this->news_detail);
        $latest_news = FrontNews::select('id', 'title', 'slug', 'publish_status', 'img_url')
            ->where('slug', '!=', $this->news_detail->slug)
            ->where('publish_status', '1')
            ->where('deleted_at', null)
            ->distinct('news.id')
            ->where('published_at', '<', Carbon::now()->toDateTimeString())
            ->orderBy('published_at', 'DESC')
            ->take(10)
            ->get();
        $this->latest_news = $latest_news;
        $ids = [$this->news_detail->id];
        // dd($latest_news);

        if ($latest_news->count()) {
            $ids = array_merge($ids, $latest_news->pluck('id')->toArray());
        }

        $this->emit('latestNews', ['latestNews' => $ids, 'content_right_advertise' =>  null ]);
    }

    public function render()
    {
        // dd('dfgsfd');
        return view('livewire.news-detail.latest-news');
    }


}
