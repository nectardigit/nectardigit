<?php

namespace App\Http\Livewire\NewsDetail;

use App\Models\FrontNews;
use Livewire\Component;

class PhotoFeatureRelatedNews extends Component
{
    public $is_news_loaded = false;
    public $news_detail;
    public $related_news;
    public $listeners = ['is_news_loaded' => "loadRelatedNews"];
    public function loadRelatedNews()
    {
        // dd($this->news_detail->newsHasCategories);
        $this->related_news =  FrontNews::select(
            'news.id',
            'news.title',
            'news.created_at',
            'news.reporter',
            'news.slug',
            'news.description',
            'news.img_url'
        )
            ->leftJoin('news_categories', 'news_categories.newsId', 'news.id')
            ->whereIn('news_categories.categoryId', $this->news_detail->newsHasCategories->pluck('id'))
            ->where('news.id','!=', $this->news_detail->id)
            ->orderBy('news.created_at', 'DESC')
            ->where('news.publish_status', '1')
            ->distinct('news.id')
            ->limit(3)
            ->get();
        // dd($this->related_news);
        $this->is_news_loaded = true;

        if ($this->related_news->count()) {

            $ids = array_merge($this->related_news->pluck('id')->toArray());
        }
        $this->emit('relatedNews',  ['relatedNews' => $ids]);
        // dd($this->related_news);
    }
    public function render()
    {
        // dd('dfsafd');
        return view('livewire.news-detail.photo-feature-related-news');
    }
}
