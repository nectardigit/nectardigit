<?php

namespace App\Traits;

use App\Models\AdvertisementPosition;
use App\Models\FrontCategory;
use App\Models\FrontNews;
use App\Models\Menu;
use App\Models\News;
use App\Models\Video;
use App\Models\BannerNewsViews as Banner;
use Illuminate\Support\Facades\DB;

/**
 *
 */
trait BannerNewsTrait
{
    use NewsCategoryId;
    // public function __construct(FrontCategory $frontCategory)
    // {
    //     // parent::
    //     $this->frontCategory = $frontCategory;
    // }
    protected $menu_fields = [
        'id', 'title', 'slug', 'show_on', 'content_type', 'parent_id'
    ];

    protected $news_fields = [
        "news.id",
        "news.title",
        // "news.summary",
        "news.description",
        // "news.isBanner",
        // "news.isBreaking",

        "news.slug",
        // "news.guestId",
        // "news.text_position",
        "news.img_url",
        "news.isSpecial",
        "news.image_show",
        "news.publish_status",
        // "news.feature_img_url",
        "news.published_at",
        // "news.created_at",
        "news.created_by",
        // 'news.publish'
    ];

    protected function getNewsItems($menus)
    {

        foreach ($menus as $key => $value) {
            $fixed_news = null;
            if ($value->id == $this->main_news_id || $value->id == $this->arthatantra_id || $value->id == $this->banking_id  || $value->id == $this->antarbarta_id || $value->id == $this->purbhadhar_id || $value->id  == $this->auto_id) {
                $fixed_news =  FrontNews::select("*")
                    ->join('news_categories', 'news_categories.newsId', 'news.id')
                    ->where('news_categories.categoryId', $value->id)
                    ->where('news.isFixed', '1')
                    ->verifiednews()
                    ->orderBy('news.published_at', 'DESC')
                    ->first();
            }

            if ($value->id == $this->bichar_id) {
                $value->category_news_items = FrontNews::select($this->news_fields)
                    ->join('news_categories', 'news_categories.newsId', 'news.id')
                    ->where('news_categories.categoryId', $value->id)
                    ->with([
                        'news_guest:id,slug_url,name,image',
                        'news_reporters:id,slug,name,twitter,profile_image_url',
                        'user:id,name,slug',
                    ])
                    ->when($fixed_news, function ($qr) use ($fixed_news) {
                        return $qr->where('news.id', "!=", $fixed_news->id);
                    })
                    ->verifiednews()
                    ->orderBy('news.published_at', 'DESC')
                    ->limit(10)
                    ->get();
                // dd( $value->category_news_items);
            } else {
                $value->category_news_items = FrontNews::select("*")
                    ->join('news_categories', 'news_categories.newsId', 'news.id')
                    ->where('news_categories.categoryId', $value->id)
                    ->when($fixed_news, function ($qr) use ($fixed_news) {
                        return $qr->where('news.id', "!=", $fixed_news->id);
                    })
                    ->verifiednews()
                    ->orderBy('news.published_at', 'DESC')
                    ->limit(10)
                    ->get();
            }




            // dd($value);
            if ($fixed_news) {
                $value->fixed_news = $fixed_news;
            }
            // ->sortByDesc('published_at');

            // dd( 'hello', round(microtime(true) - LARAVEL_START, 2));
            // dd($value);
        }
        // dd( 'hello', round(microtime(true) - LARAVEL_START, 2));
        // dd($menus);
        return $menus;
    }

    public function homepageNews()
    {
        // $this->news->whereIn('oldId', )->update(['isSpecial', '1']);

        $banner_news = $this->getBannerNews();
        // dd($banner_news,'hello', round(microtime(true) - LARAVEL_START, 2));

        // dd( 'hello', round(microtime(true) - LARAVEL_START, 2));
        $special_news = $this->getSpecialNews();
        $menus = Menu::select($this->menu_fields)
            ->whereIn('id', $this->homepage_category)
            ->where('publish_status', '1')
            ->orderBy('position', 'asc')
            ->where('parent_id', null)
            ->where('show_on', 'like', '%homepage%')
            ->get();
        // dd($menus);
        // dd()

        // dd( 'hello', round(microtime(true) - LARAVEL_START, 2));
        $allnews = $this->getNewsItems($menus);
        // dd($allnews, 'hello', round(microtime(true) - LARAVEL_START, 2));
        // dd($allnews);
        // dd(round(microtime(true) - LARAVEL_START, 2));
        $data = array_merge(
            $this->getMainNews($allnews),
            $banner_news,
            $special_news,
            // dd($allnews, 'hello', round(microtime(true) - LARAVEL_START, 2)),
            $this->getArthaNews($allnews),
            $this->getBankingNews($allnews),
            $this->getIndustryNews($allnews),
            $this->getPurvardharNews($allnews),
            $this->getParyatanNews($allnews),
            $this->getlifeStyleNews($allnews),
            $this->getAutomobilesNews($allnews),
            $this->getsuchanaNews($allnews),
            $this->getRojgarNews($allnews),
            $this->getAgricultureNews($allnews),
            $this->getCorporateNews($allnews),
            $this->getInternationalNews($allnews),
            $this->getBicharNews($allnews),
            $this->getAnterbartaNews($allnews),
            $this->getPoliticsNews($allnews),
            $this->getPradeshNews($allnews),
            $this->getShareMarketNews($allnews),
            $this->getPhotoFeatureNews($allnews),
            $this->getVideoNews(),
            // $this->getTrendingNews(),
            // dd('hello', round(microtime(true) - LARAVEL_START, 2)),
        );

        return $data;
    }

    protected function getMainNews($allnews)
    {
        $data = [
            'main_newsCat' => null,
            'main_news_main' => null,
            'main_news' => null,
        ];
        $category_id = $this->main_news_id;
        $category_info = $allnews->firstWhere('id', $category_id);
        $main_fixed_news = $category_info->fixed_news;
        // dd($main_fixed_news);
        // dd($category_info->advertisements->where('publish_status', '1'));
        $category_info->advertisements =   $category_info->advertisements->where('publish_status', '1');
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['main_newsCat'] = $category_info;
            // $data['main_news_main'] = $category_news->first();
            $data['main_news_main'] = $main_fixed_news;
            $data['main_news'] = @$category_news->take(9);
        }
        return $data;
    }

    protected function getBannerNews()
    {
        // $test = microtime(true);
        $banner_news = $this->news
            ->where('publish_status', '1')
            ->where('isBreaking', '1')
            ->with('news_reporters')
            // ->orderBy('id', 'DESC')
            ->verifiednews()
            ->limit(3)
            ->orderBy('published_at', 'DESC')
            ->get();
        // dd($banner_news);
        // ->sortByDesc('published_at');

        $position = AdvertisementPosition::whereIn('id', [23, 24])->get();
        // dd($position);

        $advertise = $this->advertisement
            ->whereIn('position', [23, 24])
            ->where(['publish_status' => '1'])
            ->with(['get_position:id,quantity'])
            ->orderBy('order', 'ASC')
            ->get();
        $inbetweenBannerAds =   $advertise->where('position', 23);
        foreach ($inbetweenBannerAds->chunk($position->firstWhere('id', 23)->quantity) as $ad => $advertise) {
            // dd($ad);
            // dd($banner_news[$ad]);
            if (isset($banner_news[$ad])) {
                $banner_news[$ad]->advertise = $advertise;
            }
        }
        // dd($banner_news);
        // dd($advertise);

        return [
            // "main_news" => $main_news,
            // "main_news_center" => $main_news_center,
            "banner_news" => $banner_news,
            'afterBannerAds' => $advertise->where('position', 24),
            'inbetweenBannerAds' => $advertise->where('position', 23),
            // 'main_news_Ads' => $main_news_Ads
        ];
    }

    protected function getSpecialNews()
    {
        $data = [
            "capital_bishesh_main" => null,
            "capital_bishesh" => null,
        ];
        $fixed_news =  $this->news
            ->select($this->news_fields)
            ->with(['news_reporters:id,slug,name,twitter,profile_image_url'])
            ->where('isSpecial', '1')
            ->where('isFixed', '1')
            ->where('publish_status', '1')
            ->verifiednews()
            ->orderBy('published_at', 'DESC')
            ->first();

        $capital_bishesh =  $this->news
            ->select($this->news_fields)
            ->with(['news_reporters:id,slug,name,twitter,profile_image_url'])
            ->where('publish_status', '1')
            ->where('isSpecial', '1')
            ->when($fixed_news, function ($qr) use ($fixed_news) {
                return $qr->where("id", '!=', $fixed_news->id);
            })
            ->verifiednews()
            ->orderBy('published_at', 'DESC')
            ->take(3)
            ->get();

        if ($capital_bishesh && $capital_bishesh->count()) {
            $data['capital_bishesh_main'] = $fixed_news   ? $fixed_news : null;
            $data['capital_bishesh'] = $capital_bishesh && $capital_bishesh->count() ? @$capital_bishesh->take(3) : null;
        }
        // dd('hello', round(microtime(true) - LARAVEL_START, 2));
        $capital_cat_position = AdvertisementPosition::where('key', 'CAPITAL_BISESH')->first();
        // dd($capital_cat_position);
        // dd('hello', round(microtime(true) - LARAVEL_START, 2));
        if ($capital_cat_position) {
            $advertise =  $this->advertisement
                ->leftJoin('advertisement_positions', 'advertisement_positions.id', 'advertisements.position')
                ->with(['get_position:id,quantity'])
                ->where("advertisement_positions.key", 'CAPITAL_BISESH')
                ->where('advertisements.position', $capital_cat_position->id)
                ->where('advertisements.publish_status', '1')
                ->orderBy('advertisements.order', 'ASC')
                ->get();

            $data['capital_advertise'] = $advertise;
            $data['capital_cat_position'] = $capital_cat_position;
        }
        // dd('hello', round(microtime(true) - LARAVEL_START, 2));
        // dd($advertise);
        return $data;
    }

    public function getArthaNews($allnews)
    {
        // dd($allnews);
        $data = [
            'arthaCat' => null,
            'artha_main' => null,
            'artha' => null,
        ];
        $category_id = $this->arthatantra_id;
        $category_info = $allnews->where('id', $category_id)->first();
        // dd($category_info->category_news_items);
        $fixed_news = @$category_info->fixed_news;
        // dd($fixed_news);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['arthaCat'] = $category_info;
            // $data['artha_main'] = $category_news->first();
            $data['artha_main'] = $fixed_news;
            $data['artha'] = @$category_news->take(3);
        }
        return $data;
        // $news_content = $this->getAllNews($category_id, $limit = 4);

        // $arthaCat = $news_content['category_info'];

        // $artha = @$news_content['category_news'];
        // $this->arthaCat = $arthaCat;

        // $this->artha_main = $artha && $artha->count() ? $artha->first() : null;
        // $this->artha = $artha && $artha->count() ? @$artha->skip(1) : null;

    }

    public function getBankingNews($allnews)
    {

        $data = [
            'bankingCat' => null,
            'banking_main' => null,
            'banking' => null,
        ];
        $category_id = $this->banking_id;
        $category_info = $allnews->where('id', $category_id)->first();
        // dd($category_info);
        $fixed_news = @$category_info->fixed_news;
        // dd($category_info->category_news_items);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['bankingCat'] = $category_info;
            // $data['banking_main'] = $category_news->first();
            $data['banking_main'] = $fixed_news;
            $data['banking'] = @$category_news->take(4);
        }
        return $data;
    }

    public function getIndustryNews($allnews)
    {
        $category_id = $this->udhyog_id;
        $data = [
            'industryCat' => null,
            'industry_main' => null,
            'industry' => null,
        ];

        $category_info = $allnews->where('id', $category_id)->first();
        // dd($category_info);
        // dd($category_info->category_news_items);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['industryCat'] = $category_info;
            $data['industry_main'] = $category_news->take(2);
            $data['industry'] = @$category_news->skip(2)->take(6);
        }
        return $data;
    }

    public function getPurvardharNews($allnews)
    {
        $category_id = $this->purbhadhar_id;
        $data = [
            'purbadharCat' => null,
            'purbadhar_main' => null,
            'purbadhar' => null,
        ];

        $category_info = $allnews->where('id', $category_id)->first();
        $fixed_news = @$category_info->fixed_news;
        // dd($category_info);
        // dd($category_info->category_news_items);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['purbadharCat'] = $category_info;
            // $data['purbadhar_main'] = $category_news->first();
            $data['purbadhar_main'] = @$fixed_news;
            $data['purbadhar'] = @$category_news->take(4);
        }
        return $data;
    }

    public function getParyatanNews($allnews)
    {
        $category_id = $this->paryatan_id;
        $data = [
            'paryatanCat' => null,
            'paryatan_main' => null,
            'paryatan' => null,
        ];
        $category_info = $allnews->where('id', $category_id)->first();
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['paryatanCat'] = $category_info;
            $data['paryatan_main'] = $category_news->take(2);
            $data['paryatan'] = @$category_news->skip(2)->take(3);
        }
        return $data;
    }

    public function getlifeStyleNews($allnews)
    {
        $category_id = $this->life_style_id;
        $data = [
            'lifestyleCat' => null,
            'lifestyle_main' => null,
            'lifestyle' => null,
        ];
        $category_info = $allnews->where('id', $category_id)->first();
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['lifestyleCat'] = $category_info;
            $data['lifestyle_main'] = $category_news->first();
            $data['lifestyle'] = @$category_news->skip(1)->take(4);
        }

        return $data;
    }

    public function getAutomobilesNews($allnews)
    {
        $category_id = $this->auto_id;
        $data = [
            'autoCat' => null,
            'auto_main' => null,
            'auto' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        $fixed_news = @$category_info->fixed_news;
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['autoCat'] = $category_info;
            // $data['auto_main'] = @$category_news->first();
            $data['auto_main'] = @$fixed_news;
            $data['auto'] = @$category_news->take(4);
        }
        return $data;

        // $category_id = $this->auto_id;
        // $news_content = $this->getAllNews($category_id, 5);

        // $autoCat = $news_content['category_info'];
        // $auto = @$news_content['category_news'];

        // $this->autoCat = $autoCat;

        // $this->auto_main = $auto && $auto->count() ? $auto->first() : null;
        // $this->auto = $auto && $auto->count() ? @$auto->skip(1) : null;
        // $this->getAgricultureNews();
        // $this->auto_mobiles_section_load = true;
        // $this->emit('auto_mobiles_section_load');
    }
    public function getsuchanaNews($allnews)
    {
        $category_id = $this->suchana_prabidhi_id;
        $data = [
            'suchanaCat' => null,
            'suchana_main' => null,
            'suchana' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['suchanaCat'] = $category_info;
            $data['suchana_main'] = @$category_news->take(2);
            $data['suchana'] = @$category_news->skip(2)->take(4);
        }
        return $data;

        // $category_id = $this->suchana_prabidhi_id;

        // $news_content = $this->getAllNews($category_id, $limit = 6);

        // $suchanaCat = $news_content['category_info'];
        // $suchana = @$news_content['category_news'];
        // $this->suchanaCat = $suchanaCat;

        // $this->suchana_main = $suchana && $suchana->count() ? $suchana->take(2) : null;
        // $this->suchana = $suchana && $suchana->count() ? @$suchana->skip(2) : null;

        // $this->suchana_section_load = true;
        // $this->emit('suchana_section_load');
        // $this->getRojgarNews();
        // $suchana = $this->news
        // // ->whereJsonContains('category', 7)
        //     ->select('id', 'title', 'slug',  'news_language', 'created_at')
        //     ->where('publish_status', '1')
        //     ->orderBy('created_at', 'DESC')
        //     ->take(7)
        //     ->get();
    }
    protected function getRojgarNews($allnews)
    {
        $category_id = $this->rojgar_id;
        $data = [
            'employmentCat' => null,
            'employment' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['employmentCat'] = $category_info;
            $data['employment'] = @$category_news->take(5);
        }
        return $data;
        // $category_id = $this->rojgar_id;
        // $news_content = $this->getAllNews($category_id, 5);
        // // dd($news_content);
        // $employmentCat = $news_content['category_info'];
        // $employment = @$news_content['category_news'];

        // $this->employmentCat = $employmentCat;

        // $this->employment = $employment && $employment->count() ? @$employment : null;
    }
    protected function getAgricultureNews($allnews)
    {
        $category_id = $this->krishi_id;
        $data = [
            'agricultureCat' => null,
            'agriculture' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['agricultureCat'] = $category_info;
            $data['agriculture'] = @$category_news->take(5);
        }
        return $data;
        // $category_id = $this->krishi_id;
        // $news_content = $this->getAllNews($category_id, 3);

        // $agricultureCat = $news_content['category_info'];
        // $agriculture = @$news_content['category_news'];
        // $this->agricultureCat = $agricultureCat;

        // $this->agriculture = $agriculture && $agriculture->count() ? @$agriculture : null;
    }
    public function getCorporateNews($allnews)
    {
        $category_id = $this->corporate_id;
        $data = [
            'corporateCat' => null,
            'corporate_main' => null,
            'corporate' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['corporateCat'] = $category_info;
            $data['corporate_main'] = @$category_news->take(2);
            $data['corporate'] = @$category_news->skip(2)->take(9);
        }
        return $data;
        // $category_id = $this->corporate_id;
        // $news_content = $this->getAllNews($category_id, 11);

        // $corporateCat = $news_content['category_info'];
        // $corporate = @$news_content['category_news'];
        // $this->corporateCat = $corporateCat;
        // // dd($corporateCat);
        // $this->corporate_main = $corporate && $corporate->count() ? $corporate->take(2) : null;
        // // dd( $this->corporate_main);
        // $this->corporate = $corporate && $corporate->count() ? @$corporate->skip(2) : null;
        // $this->getInternationalNews();
        // $this->corporate_section_load = true;
        // $this->emit('corporate_section_load');
    }
    protected function getInternationalNews($allnews)
    {
        $category_id = $this->international_id;
        $data = [
            'internationalCat' => null,
            'international' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['internationalCat'] = $category_info;
            $data['international'] = @$category_news->take(7);
        }
        return $data;

        // $category_id = $this->international_id;

        // $news_content = $this->getAllNews($category_id,7);

        // $internationalCat = $news_content['category_info'];
        // $international = @$news_content['category_news'];
        // $this->internationalCat = $internationalCat;

        // $this->international = $international && $international->count() ? @$international : null;
    }
    public function getBicharNews($allnews)
    {
        $category_id = $this->bichar_id;
        // dd($this->bichar_id);
        // dd($allnews);
        $data = [
            'bicharCat' => null,
            'bichar' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        // dd($category_info);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['bicharCat'] = $category_info;
            $data['bichar'] = @$category_news->take(4);
        }
        return $data;

        // $category_id = 11;
        // $news_content = $this->getAllNews($category_id, 4);

        // $bicharCat = $news_content['category_info'];
        // $bichar = @$news_content['category_news'];

        // $this->bicharCat = $bicharCat;

        // $this->bichar = $bichar && $bichar->count() ? @$bichar : null;
        // $this->bichar_section_load = true;
        // $this->emit('bichar_section_load');
    }
    public function getAnterbartaNews($allnews)
    {
        $category_id = $this->antarbarta_id;
        $data = [
            'antarbartaCat' => null,
            'antarbarta_main' => null,
            'antarbarta' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        $fixed_news = @$category_info->fixed_news;
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['antarbartaCat'] = $category_info;
            // $data['antarbarta_main'] = @$category_news->first();
            $data['antarbarta_main'] = @$fixed_news;
            $data['antarbarta'] = @$category_news->skip(1)->take(4);
        }
        return $data;
        // $category_id = $this->antarbarta_id;
        // $news_content = $this->getAllNews($category_id, 8);

        // $antarbartaCat = $news_content['category_info'];
        // $antarbarta = @$news_content['category_news'];
        // $this->antarbartaCat = $antarbartaCat;

        // $this->antarbarta_main = $antarbarta && $antarbarta->count() ? $antarbarta->first() : null;
        // $this->antarbarta = $antarbarta && $antarbarta->count() ? @$antarbarta->skip(1) : null;
        // $this->getPoliticsNews();
        // $this->antarbarta_section_load = true;
        // $this->emit('antarbarta_section_load');
    }
    protected function getShareMarketNews($allnews)
    {
        $category_id = $this->share_id;
        $data = [
            'shareCat' => null,
            'share_main' => null,
            'share' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['shareCat'] = $category_info;
            $data['share_main'] = @$category_news->first();
            $data['share'] = @$category_news->skip(1)->take(3);
        }
        return $data;
    }
    public function getPhotoFeatureNews($allnews)
    {

        $category_id = $this->photo_feature_id;
        $data = [
            'photoFeatureCat' => null,
            'photoFeature_main' => null,
            'photoFeature' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        // dd($category_info->advertisements);
        // $photo_feature_above = $category_info->advertisements->where('key', 'ABOVE_PHOTO_FEATURE');
        // dd($photo_feature_above);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['photoFeatureCat'] = $category_info;
            $data['photoFeature_main'] = @$category_news->first();
            $data['photoFeature'] = @$category_news->skip(1)->take(7);
        }
        return $data;
    }
    protected function getVideoNews()
    {

        $videos = Video::orderBy('created_at', 'desc')->take(7)->get();
        // dd($videos);
        // $this->latest_video = $videos ? $videos->first() : null;
        // $this->videos = $videos ? $videos->skip(1) : null;

        $data = [
            'videos' => null,
            'latest_video' => null,
        ];
        $advertise = $this->advertisement
            ->leftJoin('advertisement_positions', 'advertisement_positions.id', 'advertisements.position')
            ->where('advertisement_positions.key', 'ABOVE_VIDEOS')
            ->where('advertisements.publish_status', '1')
            ->limit(6)
            ->get();
        // dd($advertise);
        if ($videos && $videos->count()) {
            $data['latest_video'] = $videos->first();
            $data['videos'] = $videos->skip(1);
            $data['video_section_ad'] = $advertise;
        }
        return $data;
    }
    protected function getPoliticsNews($allnews)
    {
        $category_id = $this->rajneeti_id;
        $data = [
            'politicCat' => null,
            'politic' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        if ($category_info) {
            $category_news = $category_info->category_news_items;
            $data['politicCat'] = $category_info;
            $data['politic'] = @$category_news->take(8);
        }
        return $data;
    }

    protected function getPradeshNews($allnews)
    {
        $category_id = $this->pradesh_id;
        $data = [
            'pradeshCat' => null,
            'pradesh' => null,
        ];
        $category_info = $allnews->firstWhere('id', $category_id);
        $pradesh = $allnews->where('parent_id', $category_id);
        foreach ($pradesh as $key => $pradesh_news) {
            $pradesh_news['category_news_items'] = $pradesh_news->category_news_items->take(5);
        }
        if ($category_info) {

            $data['pradeshCat'] = $category_info;
            $data['pradesh'] = $pradesh;
        }

        return $data;
    }
    protected function getTrendingNews()
    {


        $data['trending'] = FrontNews::select('id', 'slug', 'title', 'created_at', 'view_count')
            ->where('published_at', '>', now()->subdays(12))
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();


        return $data;
    }
}
