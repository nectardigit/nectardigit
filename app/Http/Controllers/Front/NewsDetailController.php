<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AdvertisementPosition;
use App\Models\AppSetting;
use App\Models\FrontCategory;
use App\Models\FrontNews;
use App\Models\NewsGuest;
use App\Models\User;
use App\Traits\NewsDetailTrait;
use App\Traits\SharedTrait;
use Illuminate\Http\Request;

class NewsDetailController extends Controller
{
    //\
    use SharedTrait;
    use NewsDetailTrait;
    public $categoryKey = ['menus.id', 'menus.title', 'menus.slug', 'newsId', 'categoryId'];

    public function __construct(FrontNews $news, FrontCategory $category, AdvertisementPosition $ad_position, User $reporter, NewsGuest $guest)
    {
        $this->news = $news;
        $this->category = $category;
        $this->ad_position = $ad_position;
        $this->reporter = $reporter;
        $this->guest = $guest;
    }
    public function newsDetail(Request $request, $slug)
    {
        // dd($slug);

        $news_detail = $this->getNewsInformation($slug);
        $this->news->where('slug',$slug)->increment('view_count');
        // dd($news_detail);
        // if($news_detail){
        //     $this->news->where('slug',$slug)->increment('view_count');
        // }
        abort_if(!$news_detail, 404);
        $advertisements = $this->getNewsDetailAdvertisement();
        // dd($advertisements);

        $data = $this->poolNewsDetail($news_detail, $slug);
        $data = array_merge($data, $advertisements);

        $html = view('layouts.news-inner-advertise')->with("inside_content_ad", $data['inside_content_ad'])->render();
        $add_to_read_news = $news_detail->newsHasAddToReadNews;
        $add_to_read_html = view('website.news.add-to-read-news', compact('add_to_read_news'))->render();

        // dd($add_to_read_news);

        // dd($news_detail->description['np']);
        if ($add_to_read_news) {
            $content = $this->injectAdvertisementInsideContent($news_detail, $html, $add_to_read_html);
        } else {
            $content = $this->injectAdvertisementInsideContent($news_detail, $html);
        }

        $data['content'] = $content;
        $data['meta'] = $this->getMetaData($news_detail);
        // dd($data);
        // dd($data['meta']);
        // event(new NewsTagCountEvent($news_detail));
        // dd(round(microtime(true) - LARAVEL_START, 2));
        if ($news_detail->isPhotoFeature || in_array(27, $news_detail->newsHasCategories->pluck('id')->toArray())  ) {
            return view('website.news.photoFeature', $data);
        } else {
            return view('website.news.news-detail', $data);
        }
    }

    protected function injectAdvertisementInsideContent($news_detail, $ad_html, $add_to_read_html = null)
    {
        $content = html_entity_decode($news_detail->description['np']);
        // dd($content);
        $content = explode("</p>", $content);
        $paragraphAfter = 1; //display after the first paragraph
        foreach ($content as $key => $content_data) {
            if ($key == $paragraphAfter) {
                $content[$key] = $content_data . "</p><p>" . $ad_html;
            } else {
                $content[$key] = $content_data;
            }
            if ($key == 3 && $add_to_read_html) {
                $content[$key] = $content_data . "</p><p>" . $add_to_read_html;
            }
            // dd($content_data);
        }
        $content = implode("</p>", $content);
        // dd($content);
        return $content;
    }

    protected function getMetaData($news_detail)
    {

        $website = AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        // dd($website);
        $meta = [
            'meta_title' => $news_detail->title['np'] ?? @$website->meta_title ?? null,
            'meta_keyword' => @$news_detail->meta_keyword ?? @$website->meta_keyword ?? null,
            'meta_description' => parse_description($news_detail, false, 200) ?? @$website->meta_description ?? null,
            'meta_keyphrase' => @$news_detail->meta_keyphrase ?? @$website->meta->keyphrase ?? null,
            'og_image' => create_image_url($news_detail->img_url, 'banner') ?? 'capital-og_image',
            'og_url' => route('newsDetail', $news_detail->slug),
            'og_site_name' => $website->name,
        ];
        return $meta;
    }
}
