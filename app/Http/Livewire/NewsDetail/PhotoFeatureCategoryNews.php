<?php

namespace App\Http\Livewire\NewsDetail;

use App\Models\FrontNews;
use Livewire\Component;

class PhotoFeatureCategoryNews extends Component
{
    public $is_news_loaded = false;
    public $news_detail;
    public $category;
    public $category_news;
    public $listeners = ['relatedNews' => "loadCategoryNews"];
    public function loadCategoryNews($relatedNews_ids)
    {
        // dd($relatedNews_ids);
        $this->is_news_loaded = true;
        $cache = implode('-', $relatedNews_ids['relatedNews']);
        // dd($cache);

        $this->category_news =  FrontNews::select(
            'news.id',
            'news.title',
            'news.created_at',
            'news.reporter',
            'news.slug',
            'news.description',
            'news.img_url'
        )
            ->leftJoin('news_categories', 'news_categories.newsId', 'news.id')
            ->whereNoTIn('news.id', $relatedNews_ids['relatedNews'])
            ->where('news.id','!=', $this->news_detail->id)
            ->whereIn('news_categories.categoryId', $this->news_detail->newsHasCategories->pluck('id'))
            ->distinct('news.id')
            ->orderBy('news.created_at', 'DESC')
            ->where('publish_status', '1')
            ->limit(6)
            ->get();




    }
    public function render()
    {
        return view('livewire.news-detail.photo-feature-category-news');
    }
}
