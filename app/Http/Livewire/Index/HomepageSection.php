<?php

namespace App\Http\Livewire\Index;

use App\Models\FrontCategory;
use App\Models\FrontNews;
use App\Traits\HomepageNewsTrait;
use Livewire\Component;

class HomepageSection extends Component
{

    use HomepageNewsTrait;

    public $bishesh_section_load = false;
    public $arthatantra_section_load = false;
    public $banking_section_load = false;
    public $video_section_load = false;
    public $factory_section_load = false;
    public $purbadhar_section_load = false;
    public $paryatan_section_load = false;
    public $auto_mobiles_section_load = false;
    public $suchana_section_load = false;
    public $corporate_section_load = false;
    public $bichar_section_load = false;
    public $load_pradesh_section = false;
    public $antarbarta_section_load = false;
    public $load_photo_section = false;
    public $front_category = null ;
    public $news;
    public function mount(FrontCategory $front_category, FrontNews $news){
        $this->front_category = $front_category;
        $this->news = $news;
    }
    protected $listeners = [
        'homepageLoaded' => 'getCapitalBisheshNews',
        'bishesh_section_load' => "getArthaNews",
        'arthatantra_section_load' => "getBankingNews",
        'banking_section_load' => "getVideoNews",
        "video_section_load" => "getIndustryNews",
        "factory_section_load" => "getPurvardharNews",
        "purbadhar_section_load" => "getParyatanNews",
        "paryatan_section_load" => "getAutomobilesNews",
        "auto_mobiles_section_load" => "getsuchanaNews",
        "suchana_section_load" => "getCorporateNews",
        "corporate_section_load" => "getBicharNews",
        "bichar_section_load" => "getPradeshNews",
        "load_pradesh_section" => "getAnterbartaNews",
        "antarbarta_section_load" => "getPhotoFeatureNews",
        // "load_photo_section" => ""
    ];
   
    public function render()
    {
        return view('livewire.index.homepage-section');
    }

    protected function getAllNews($category_id, $limit = 10)
    {
        $menus = cache()->remember('app_menu', 60 * 60 * 24, function () {
            return FrontCategory::select('id', 'title', 'slug', 'show_on', 'content_type')
            ->whereIn('id', $this->homepage_category)
                ->where('publish_status', '1')
                ->with([
                    'advertisements' => function ($qr) {
                        return $qr->select('*')->where('page', 'homepage')
                        ->orderBy('advertisements.created_at', 'desc')
                        ->take(5);
                    },
                ])
                ->orderBy('position', 'ASC')
                ->where('parent_id', null)
                ->get();
        });
        $category_info = $menus->where('id', $category_id)->first();
        if(!$category_info){
            return [
                'category_news' =>null ,
                // 'advertisements' => $category_news,
                "category_info" => null,
            ];
        }
        // dd($category_info);
        // dd(round(microtime(true) - LARAVEL_START, 2));
        // cache()->forget("hemepage_news_cache_".$category_info->id);
        // dd($menus->get_test_news);
        return $category_news = cache()->remember("hemepage_news_cache_" . $category_info->id, 60 * 60, function () use ($category_info, $limit) {
            $category_news = $this->news->
                // ->select('id', 'category', 'thumbnail', "path", 'title', 'slug', 'created_at')
                select(
                    'news.id',
                    'news.title',
                    'news.slug',
                 
                  
                    'news.description',
              
                    'news.news_language',
                    'news.created_at',
                    'news.published_at',
                    'news.text_position',
                    'news.reporter',
            
                    "news.img_url",
                   
              
                    "news.published_at",
                    "news.created_at",
                    'news_categories.newsId',
                    'news_categories.categoryId'
                )
                ->leftJoin('news_categories', 'news_categories.newsId', 'news.id')
                ->where('news_categories.categoryId', $category_info->id)
                ->verifiednews()
                // ->with(['newsHasCategories'])
                ->where('news.publish_status', '1')
                ->where('news.deleted_at', null)
                // FrontNews
                // ->whereHas('newsHasCategories', function ($qr) use ($category_info) {
                //     return $qr->where('categoryId', $category_info->id);
                // })
                ->limit($limit)
                ->orderBy('news.created_at', 'DESC')
                ->get();
            // dd(round(microtime(true) - LARAVEL_START, 2));
            // dd($category_news);
            return [
                'category_news' => $category_news,
                // 'advertisements' => $category_news,
                "category_info" => $category_info,
            ];
        });
    }
}
