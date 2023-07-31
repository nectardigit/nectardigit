<?php

namespace App\Http\Livewire\NewsDetail;

use App\Models\FrontNews;
use Livewire\Component;

class RelatedNews extends Component
{
    public $is_news_loaded = false;
    public $news_detail;
    public $related_news;
    public $listeners = ['latestNews' => "loadRelatedNews"];
    public function loadRelatedNews($latestNews_ids)
    {

        // dd($this->news_detail->newsHasCategories);
        $this->related_news =  FrontNews::select(
            'news.id',
            'news.title',
            'news.published_at',
            'news.reporter',
            'news.slug',
            'news.description',
            'news.img_url',
        )
            ->leftJoin('news_categories', 'news_categories.newsId', 'news.id')
            ->whereIn('news_categories.categoryId', $this->news_detail->newsHasCategories->pluck('id'))
            ->whereNotIn('news.id', $latestNews_ids['latestNews'])
            ->orderBy('news.published_at', 'DESC')
            ->distinct('news.id')
            ->where('news.publish_status', '1')
            ->limit(3)
            ->get();

        $this->is_news_loaded = true;

        $ids = $latestNews_ids['latestNews'];
        if ($this->related_news->count()) {
            $ids = array_merge($ids, $this->related_news->pluck('id')->toArray());
            // dd($ids);
        }
        $this->emit('relatedNews',  ['relatedNews' => $ids]);
        
    }
    public function render()
    {
        return view('livewire.news-detail.related-news');
    }
}
