<?php

namespace App\Traits;

use App\Models\FrontCategory;
use App\Models\FrontNews;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
trait HomepageNewsTrait
{
    protected $main_news_id = 3;
    protected $arthatantra_id = 4;
    protected $banking_id = 5;
    protected $share_id = 6;
    protected $udhyog_id = 1;
    protected $life_style_id = 30;
    protected $purbhadhar_id = 8;
    protected $paryatan_id = 9;
    protected $auto_id = 28;
    protected $krishi_id = 23;
    protected $suchana_prabidhi_id = 10;
    protected $rojgar_id = 29;
    protected $corporate_id = 13;
    protected $international_id = 32;
    protected $bichar_id = 11;
    protected $pradesh_id = 12;
    protected $antarbarta_id = 25;
    protected $rajneeti_id = 2;
    protected $photo_feature_id = 27;
    protected $homepage_category = [
        3, 4, 5, 6, 1, 30, 8, 9, 28, 23, 10, 29, 13, 32, 11, 12, 25, 2, 27
    ];


    protected $news_fields = [
        "news.id",
        "news.title",
        "news.summary",
        "news.description",
        "news.isBanner",
        "news.isBreaking",

        "news.slug",
        "news.guestId",
        "news.text_position",
        "news.img_url",


        "news.feature_img_url",
        "news.published_at",
        "news.created_at",
    ];
    // public $capital_bisheshCat;
    // public $capital_bishesh_main;
    // public $capital_bishesh;
    public $banking;
    public $banking_main;
    public $bankingCat;
    public $pradeshCat;
    public $pradesh_news;
    public $pradesh_news_first;
    public $shareCat;
    public $share;
    public $share_main;
    public $purbadhar;
    public $purbadharCat;
    public $purbadhar_main;
    public $paryatan;
    public $paryatanCat;
    public $paryatan_main;
    public $artha;
    public $artha_main;
    public $arthaCat;
    public $lifestyle;
    public $lifestyleCat;
    public $auto;
    public $autoCat;
    public $agriculture;
    public $agricultureCat;
    public $suchana;
    public $suchana_main;
    public $suchanaCat;
    public $corporate;
    public $corporateCat;
    public $international;
    public $internationalCat;
    public $bichar;
    public $bicharCat;
    public $antarbarta;
    public $antarbartaCat;
    public $politic;
    public $politicCat;
    public $photoFeature;
    public $photoFeatureCat;
    public $employment;
    public $employmentCat;
    public $industry;
    public $industryCat;
    public $latest_video;
    public $videos;
    public $pradeshId;
    public $trending;
    public $industry_main;
    public $auto_main;
    public $corporate_main;
    public $photoFeature_main;
    public function getCapitalBisheshNews()
    {

        // $category_id = 36;
        // $news_content = $this->getAllNews($category_id, $limit = 9);
        // // $capital_bisheshCat = $news_content;
        // $this->capital_bisheshCat = $news_content['category_info'];
        // $capital_bishesh = @$news_content['category_news'];

        // $this->capital_bishesh_main = $capital_bishesh && $capital_bishesh->count() ? $capital_bishesh->first() : null;

        // $this->capital_bishesh = $capital_bishesh && $capital_bishesh->count() ? @$capital_bishesh->skip(1) : null;
        $this->bishesh_section_load = true;
        $this->emit('bishesh_section_load');

        // $this->emit('bishesh_section_load');
        // dd($this->bishesh_section_load);
        // return [
        //     "capital_bisheshCat" => $capital_bisheshCat,
        //     "capital_bishesh_main" => $capital_bishesh_main,
        //     "capital_bishesh" => $capital_bishesh,
        // ];
    }

    public function getArthaNews()
    {
        // $news_content = cache()->remember('get_artha_news_section', 60 * 60, function () {

        //     $category_id = 4;
        //     return FrontCategory::with(['categoriesHasNews' => function ($qr) {
        //         return $qr->select($this->news_fields)
        //             ->where('publish_status', '1')
        //         // ->whereDate('news.created_at',today()->subMonths(2))
        //             ->orderBy('news.published_at', 'DESC')
        //         // ->latest()
        //             ->take(4);
        //     }])
        //         ->where('id', $category_id)
        //         ->first();
        // });
        $category_id = $this->arthatantra_id;
        $news_content = $this->getAllNews($category_id, $limit = 4);

        $arthaCat = $news_content['category_info'];

        $artha = @$news_content['category_news'];
        $this->arthaCat = $arthaCat;

        $this->artha_main = $artha && $artha->count() ? $artha->first() : null;
        $this->artha = $artha && $artha->count() ? @$artha->skip(1) : null;

        $this->arthatantra_section_load = true;
        $this->emit('arthatantra_section_load');
    }

    public function getBankingNews()
    {
        $category_id = $this->banking_id;

        $news_content = $this->getAllNews($category_id, 5);

        $bankingCat = $news_content['category_info'];
        $banking = @$news_content['category_news'];
        $this->bankingCat = $bankingCat;

        $this->banking_main = $banking && $banking->count() ? $banking->first() : null;
        $this->banking = $banking && $banking->count() ? @$banking->skip(1) : null;
        $this->getShareMarketNews();
        $this->banking_section_load = true;
        $this->emit("banking_section_load");
    }

    public function getVideoNews()
    {

        $videos = Video::orderBy('created_at', 'desc')->take(7)->get();
        $this->latest_video = $videos ? $videos->first() : null;
        $this->videos = $videos ? $videos->skip(1) : null;
        $this->video_section_load = true;
        $this->emit('video_section_load');
    }
    public function getIndustryNews()
    {
        $category_id = $this->udhyog_id;
        $news_content = $this->getAllNews($category_id, 8);

        $industryCat = $news_content['category_info'];
        $industry = @$news_content['category_news'];
        $this->industryCat = $industryCat;

        $this->industry_main = $industry && $industry->count() ? $industry->take(2) : null;
        $this->industry = $industry && $industry->count() ? @$industry->skip(2) : null;
        $this->getlifeStyleNews();
        $this->factory_section_load = true;
        $this->emit('factory_section_load');
        // $industry = $this->news
        // // ->whereJsonContains('category', 5)
        //     ->select('id', 'title', 'slug', 'thumbnail', 'path', 'news_language', 'created_at')
        //     ->where('publish_status', '1')
        //     ->orderBy('created_at', 'DESC')
        //     ->take(8)
        //     ->get();
        // $industry_main = $industry->take(2);
        // $industry = $industry->skip(2);
    }
    public function getPurvardharNews()
    {

        $category_id = $this->purbhadhar_id;
        $news_content = $this->getAllNews($category_id, 5);

        $purbadharCat = $news_content['category_info'];
        $purbadhar = @$news_content['category_news'];
        $this->purbadharCat = $purbadharCat;

        $this->purbadhar_main = $purbadhar && $purbadhar->count() ? $purbadhar->first() : null;
        $this->purbadhar = $purbadhar && $purbadhar->count() ? @$purbadhar->skip(1) : null;
        $this->purbadhar_section_load = true;
        $this->getTrendingNews();
        $this->emit('purbadhar_section_load');
    }

    public function getParyatanNews()
    {
        $category_id = $this->paryatan_id;
        $news_content = $this->getAllNews($category_id,$limit = 5);

        $paryatanCat = $news_content['category_info'];
        $paryatan = @$news_content['category_news'];
        $this->paryatanCat = $paryatanCat;

        $this->paryatan_main = $paryatan && $paryatan->count() ? $paryatan->take(2) : null;
        $this->paryatan = $paryatan && $paryatan->count() ? @$paryatan->skip(2) : null;
        $this->paryatan_section_load = true;
        $this->emit('paryatan_section_load');
    }

    public function getAutomobilesNews()
    {

        $category_id = $this->auto_id;
        $news_content = $this->getAllNews($category_id, 5);

        $autoCat = $news_content['category_info'];
        $auto = @$news_content['category_news'];

        $this->autoCat = $autoCat;

        $this->auto_main = $auto && $auto->count() ? $auto->first() : null;
        $this->auto = $auto && $auto->count() ? @$auto->skip(1) : null;
        $this->getAgricultureNews();
        $this->auto_mobiles_section_load = true;
        $this->emit('auto_mobiles_section_load');
    }

    public function getsuchanaNews()
    {

        $category_id = $this->suchana_prabidhi_id;

        $news_content = $this->getAllNews($category_id, $limit = 6);

        $suchanaCat = $news_content['category_info'];
        $suchana = @$news_content['category_news'];
        $this->suchanaCat = $suchanaCat;

        $this->suchana_main = $suchana && $suchana->count() ? $suchana->take(2) : null;
        $this->suchana = $suchana && $suchana->count() ? @$suchana->skip(2) : null;

        $this->suchana_section_load = true;
        $this->emit('suchana_section_load');
        $this->getRojgarNews();
        // $suchana = $this->news
        // // ->whereJsonContains('category', 7)
        //     ->select('id', 'title', 'slug', 'thumbnail', 'path', 'news_language', 'created_at')
        //     ->where('publish_status', '1')
        //     ->orderBy('created_at', 'DESC')
        //     ->take(7)
        //     ->get();
    }

    public function getCorporateNews()
    {
        $category_id = $this->corporate_id;
        $news_content = $this->getAllNews($category_id, 11);

        $corporateCat = $news_content['category_info'];
        $corporate = @$news_content['category_news'];
        $this->corporateCat = $corporateCat;
        // dd($corporateCat);
        $this->corporate_main = $corporate && $corporate->count() ? $corporate->take(2) : null;
        // dd( $this->corporate_main);
        $this->corporate = $corporate && $corporate->count() ? @$corporate->skip(2) : null;
        $this->getInternationalNews();
        $this->corporate_section_load = true;
        $this->emit('corporate_section_load');
    }

    public function getBicharNews()
    {

        $category_id = 11;
        $news_content = $this->getAllNews($category_id, 4);

        $bicharCat = $news_content['category_info'];
        $bichar = @$news_content['category_news'];

        $this->bicharCat = $bicharCat;

        $this->bichar = $bichar && $bichar->count() ? @$bichar : null;
        $this->bichar_section_load = true;
        $this->emit('bichar_section_load');
    }

    public function getPradeshNews($categoryId = null)
    {

        $category_id = $this->pradesh_id;
        $pradeshCat = $this->front_category->select('id', 'title', 'slug')
            ->where('id', $category_id)
            ->where('publish_status', '1')
            ->with(['child_menu' => function ($query) {
                $query->select('id', 'title', 'slug', 'position', 'parent_id')->orderBy('position', 'Asc');
            }])
            ->first();

        // $pradesh = FrontCategory::select('id', 'title', 'slug')
        //     ->where('parent_id', $category_id)
        //     ->where('publish_status', '1')
        //     ->with(['categoriesHasNews' => function ($query) {
        //         return $query->take(5);
        //     }])
        //     ->get();

        $category = @$pradeshCat->child_menu[0];
        // dd($category);
        // dd($pradesh_news);
        $this->pradeshCat = $pradeshCat;
        $this->getsinglePredeshNews(@$category->id);
        // $this->pradesh_news = @$pradesh;

        // dd($pradesh_news);

        $this->load_pradesh_section = true;
        $this->emit('load_pradesh_section');

        // $pradesh_news = $this->category->select('id', 'title', 'slug', 'content_type')
        //     ->where('parent_id', 22)
        //     ->with(['category_news' => function ($qr) {
        //         return $qr->limit(8);
        //     }])->get();
    }

    public function getsinglePredeshNews($categoryId)
    {
        $variable = "pradesh-" . $categoryId;
        $pradesh_news = cache()->remember($variable, 60 * 60 * 24, function () use ($categoryId) {
            return   FrontNews::select(
                $this->news_fields
            )->where('publish_status', '1')->whereHas('newsHasCategories', function ($qr) use ($categoryId) {
                return $qr->where('categoryId', $categoryId)
                    ->where('published_at', '<', Carbon::now())
                    ->where('deleted_at', null)
                    ->where('publish_status', "1")
                    ->orderBy('published_at', 'desc');
            })
                ->orderBy('created_at', "DESC")
                ->take(5)
                ->get();
        });
        $this->pradeshId = $categoryId;
        // dd($pradesh_news);
        $this->pradesh_news_first = $pradesh_news->first();
        $this->pradesh_news = $pradesh_news->skip(1);
    }

    public function getAnterbartaNews()
    {
        $category_id = $this->antarbarta_id;
        $news_content = $this->getAllNews($category_id, 8);

        $antarbartaCat = $news_content['category_info'];
        $antarbarta = @$news_content['category_news'];
        $this->antarbartaCat = $antarbartaCat;

        $this->antarbarta_main = $antarbarta && $antarbarta->count() ? $antarbarta->first() : null;
        $this->antarbarta = $antarbarta && $antarbarta->count() ? @$antarbarta->skip(1) : null;
        $this->getPoliticsNews();
        $this->antarbarta_section_load = true;
        $this->emit('antarbarta_section_load');
    }

    public function getPhotoFeatureNews()
    {

        $category_id = $this->photo_feature_id;
        $news_content = $this->getAllNews($category_id);

        $photoFeatureCat = $news_content['category_info'];
        $photoFeature = @$news_content['category_news'];
        $this->photoFeatureCat = $photoFeatureCat;

        $this->photoFeature_main = $photoFeature && $photoFeature->count() ? $photoFeature->first() : null;
        $this->photoFeature = $photoFeature && $photoFeature->count() ? @$photoFeature->skip(1) : null;
        $this->load_photo_section = true;
        $this->emit('load_photo_section');
    }
    protected function getShareMarketNews()
    {
        $category_id = $this->share_id;
        $news_content = $this->getAllNews($category_id, 3);
        // dd($news_content);
        $shareCat = $news_content['category_info'];
        $share = @$news_content['category_news'];
        $this->shareCat = $shareCat;

        $this->share_main = $share && $share->count() ? $share->first() : null;
        $this->share = $share && $share->count() ? @$share->skip(1) : null;

        // $share = $this->news
        //     ->select('id', 'title', 'slug', 'thumbnail', 'path', 'news_language', 'created_at')
        //     ->where('publish_status', '1')
        //     ->orderBy('created_at', 'DESC')
        //     ->take(5)
        //     ->get();
    }

    protected function getlifeStyleNews()
    {
        $category_id = $this->life_style_id;
        $news_content = $this->getAllNews($category_id, 6);

        $lifestyleCat = $news_content['category_info'];
        $lifestyle = @$news_content['category_news'];

        $this->lifestyleCat = $lifestyleCat;
        $this->lifestyle = $lifestyle && $lifestyle->count() ? @$lifestyle : null;
    }

    protected function getAgricultureNews()
    {
        $category_id = $this->krishi_id;
        $news_content = $this->getAllNews($category_id, 3);

        $agricultureCat = $news_content['category_info'];
        $agriculture = @$news_content['category_news'];
        $this->agricultureCat = $agricultureCat;

        $this->agriculture = $agriculture && $agriculture->count() ? @$agriculture : null;
    }

    protected function getInternationalNews()
    {

        $category_id = $this->international_id;

        $news_content = $this->getAllNews($category_id,7);

        $internationalCat = $news_content['category_info'];
        $international = @$news_content['category_news'];
        $this->internationalCat = $internationalCat;

        $this->international = $international && $international->count() ? @$international : null;
    }

    protected function getPoliticsNews()
    {

        $category_id = $this->rajneeti_id;

        $news_content = $this->getAllNews($category_id);

        $politicCat = $news_content['category_info'];
        $politic = @$news_content['category_news'];
        $this->politicCat = $politicCat;

        $this->politic = $politic && $politic->count() ? @$politic : null;
    }

    protected function getRojgarNews()
    {
        $category_id = $this->rojgar_id;
        $news_content = $this->getAllNews($category_id, 5);
        // dd($news_content);
        $employmentCat = $news_content['category_info'];
        $employment = @$news_content['category_news'];

        $this->employmentCat = $employmentCat;

        $this->employment = $employment && $employment->count() ? @$employment : null;
    }

    protected function getTrendingNews()
    {
        dd($value = Cache::get('trending_news'));
        $trending = cache()->remember('trending_news', 60 * 60, function () {
            return $this->news
                ->select('id', 'slug', 'title', 'created_at')
                ->whereDate('published_at', '>', Carbon::today()->subDays(7)->toDateString())
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get();
        });

        $this->trending = $trending;
    }


    public function homepageBiseshNews()
    {
        // $categories = cache()->remember('categories', 60 * 60, function () {
        //     return $this->category->where('content_type', 'category')->get();
        // });

        // dd($main_news);

        //  = FrontCategory::select('id', 'title', 'slug', 'show_on', 'content_type')
        //     ->where('publish_status', '1')
        //     ->with([
        //         'advertisements' => function ($qr) {
        //             return $qr->select('*')->where('page', 'homepage')->orderBy('advertisements.created_at', 'desc')->take(3);
        //         },
        //         // 'categoriesHasNews' => function ($qr) {
        //         //     $qr->select($this->news_fields)->latest() ;
        //         // }
        //     ])
        //     ->where('show_on', "like", '%homepage%')
        //     ->orderBy('position', 'ASC')
        //     ->where('parent_id', null)
        //     ->get();
        $capital_bishesh_news = $this->getCapitalBisheshNews();

        // dd($capital_bishesh_news);

        // banking starts
        $banking_news = $this->getBankingNews();

        // dd($banking_news);

        //Banking ends
        $pradeshCat = $this->getPradeshNews();

        // dd($pradeshCat);
        //share
        $purbadhar = $this->getPurvardharNews();

        $share_market_news = $this->getShareMarketNews();

        // dd($share_market_news);
        //endshares

        //Industries
        $industryCats = $this->getIndustryNews();
        //Industries end
        //purbadhar

        //purbadhar ends

        //lifestyle  जीवनशैली
        // dd($categories);
        $lifestyleNews = $this->getlifeStyleNews();

        //lifestyle ends

        //paryatan
        // dd($categories);
        $paryatan_news = $this->getParyatanNews();

        //paryatan ends
        //auto
        $automobiles_news = $this->getAutomobilesNews();

        //auto end
        //agriculture
        $agriculture_news = $this->getAgricultureNews();

        //agriculture ends
        // dd($agriculture_news);

        //suchana prabidhi Technology
        $suchanaNews = $this->getsuchanaNews();

        // dd($suchanaNews);
        //suchana prabidhi Technology ends

        //Corporate
        $corporateNews = $this->getCorporateNews();

        //Corporate ends
        //international
        $international_news = $this->getInternationalNews();

        //end international
        //bichar
        $bichar_news = $this->getBicharNews();

        //bichar ends
        //Antarbarta
        $antarbarta_news = $this->getAnterbartaNews();
        //Antarbarta ends

        //politics
        $rajneeti_news = $this->getPoliticsNews();
        //politics ends

        //photoFeautre
        $photo_feature_news = $this->getPhotoFeatureNews();
        //photoFeatures end

        //employement starts
        $rojgar_news = $this->getRojgarNews();
        //employement ends

        return $artha_news = $this->getArthaNews();
        // dd($artha_news);

        $video_content = $this->getVideoNews();

        $trending = $this->getTrendingNews();
        // dd($video_content);

        // dd(round(microtime(true) - LARAVEL_START, 2));
        $data = array_merge($main_news, $banner_news, $capital_bishesh_news, $banking_news, $pradeshCat, $share_market_news, $industryCats, $purbadhar, $lifestyleNews, $paryatan_news, $automobiles_news, $agriculture_news, $suchanaNews, $corporateNews, $international_news, $bichar_news, $antarbarta_news, $rajneeti_news, $photo_feature_news, $rojgar_news, $artha_news, $video_content, $trending);
        return $data;
    }
}
