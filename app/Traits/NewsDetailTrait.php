<?php

namespace App\Traits;

use App\Models\Advertisement;
use App\Models\FrontNews;
use Illuminate\Support\Facades\DB;

/**
 *
 */
trait NewsDetailTrait
{
    protected $news_fields = [
        "news.id",
        "news.title",
        "news.description",
        "news.slug",
        "news.img_url",
        "news.isSpecial",
        "news.image_show",
        "news.publish_status",
        "news.published_at",
        "news.created_by",
    ];
    protected function getNewsInformation($slug)
    {
        // dd($slug);
        // $slug_key = is_int($slug) ? 'slug' : 'id';
        cache()->forget("detai_news_$slug");
        $news =  cache()->remember("detai_news_$slug", now()->addHour(1), function () use ($slug) {
            // dd($slug);
            return   $news =   $this->news
                ->select(
                    "id",
                    "title",
                    "subtitle",
                    "slug",
                    "tagLine",
                    "summary",
                    "description",
                    "reporters",
                    "reporter",
                    "guest",
                    "guestId",
                    "image_caption",
                    "created_by",
                    "img_url",
                    "feature_img_url",
                    "published_at",
                    "created_at",
                    "showReporter",
                    'isPhotoFeature',
                    "created_by"
                )
                ->where('slug', "like", "%$slug%")
                // ->where(function($qr) use ($slug) {
                //     return $qr->where('slug', $slug)->orWhere("id", $slug);
                // })
                ->verifiednews()
                ->with([
                    'news_reporter:user_id,slug_url,profile_image_url',
                    'news_reporters:id,slug,name,twitter,profile_image_url',
                    'news_guest' => fn ($qr) => $qr->select('id', 'slug_url', 'name', 'image'),
                    'newsHasCategories' => fn ($qr) => $qr->select($this->categoryKey),
                    // "news_categories",
                    'newsHasTags' => fn ($qr) => $qr->select('tags.id', 'tags.title', 'tags.slug', 'tags.position', 'newsId', 'tagId'),
                    "newsHasAddToReadNews" => fn ($qr) => $qr->select('news.id', 'news.title', 'news.slug'),
                ])


                ->first();
            // dd($news);
        });
        return $news;
    }

    protected function getNewsDetailAdvertisement()
    {
        $breadcrumb = $this->advertisement_position_items()
            ->firstWhere('key', 'BEFORE_BREADCRUMB');
        $after_new_title = $this->advertisement_position_items()
            ->firstWhere('key', 'BELOW_NEWS_TITLE_AND_DATE');


        // dd($after_new_title);
        // dd($breadcrumb_position);
        $content_right = $this->advertisement_position_items()
            ->firstWhere('key', 'CONTENT_RIGHT_SIDE_FIRST');

        $inside_content = $this->advertisement_position_items()
            ->where('key', 'INSIDE_CONTENT')
            ->first();
        // dd($breadcrumb_position);
        $ad_positions = $this->advertisement_position_items()->where('page', 'news_detail')->pluck('key')->toArray();
        // dd($ad_positions);
        // cache()->forget("news_detail_advertise");
        $advertisements = cache()->remember('news_detail_advertise', 60 * 60 * 24, function () use ($ad_positions) {
            return Advertisement::select('id', 'title', 'organization', 'url', 'position', 'columnType', 'img_url', 'img_url_app')
                ->where('publish_status', '1')
                ->with(['get_position' => fn ($qr) => $qr->select('id', 'key', 'title', 'page', 'quantity')])
                ->whereHas('get_position', function ($qr) use ($ad_positions) {
                    $qr->whereIn('key', $ad_positions);
                })
                ->orderby('order', 'asc')
                ->get();
        });
        // dd($advertisements);
        // dd($breadcrumb);
        $breadcrumb_advertise = $breadcrumb ? $advertisements->where('position', $breadcrumb->id) : null;

        $content_right_advertise = $content_right ? $advertisements->where('position', $content_right->id) : null;
        $inside_content_ad = $inside_content ? $advertisements->where('position', $inside_content->id) : null;

        $after_new_title_ad = $after_new_title ? $advertisements->where('position', $after_new_title->id) : null;
        // dd($advertise_inside_content);

        return [
            "breadcrumb_advertise" => $breadcrumb_advertise,
            "content_right_advertise" => $content_right_advertise,
            "inside_content_ad" => $inside_content_ad,
            "after_new_title_ad" => $after_new_title_ad,
            "news_detail_below_content_ad" => $this->newsBelowAd($advertisements),
        ];
    }
    protected function newsBelowAd($advertisements)
    {
        $news_detail_below_content = $this->advertisement_position_items()
            ->firstWhere('key', 'BELOW_NEWS_CONTENT');

        return   $news_detail_below_content_ad = $news_detail_below_content ? $advertisements->where('position', $news_detail_below_content->id) : null;
    }
    public function replacement($string, $placeholders)
    {
        $resultString = $string;
        $resultString = str_replace('</p>', trim($placeholders), $resultString, $i);
        // foreach($placeholders as $key => $value) {
        // }
        return $resultString;
    }
    protected function poolNewsDetail($news_detail, $slug)
    {
        $data = ['news_detail' => $news_detail];
        $category = $this->category->select('id', 'slug', 'title')
            ->whereIn('id', $news_detail->newsHasCategories->pluck('categoryId'))
            ->first();

        // dd($news_detail);
        $guestId = $news_detail->guestId;
        // dd($guestId);
        // if(isset($test) && $test == 1101010101){
        if ($guestId) {
            $reporter_news = $this->news
                ->where('guestId', $news_detail->guestId)
                ->where('news.id', '!=', $news_detail->id)
                ->orderBy('news.id', 'desc')
                ->take(10)
                ->get();
            $data['reporter_news'] = $reporter_news;
        } else if (!$guestId) {
            $reporter = $news_detail->news_reporters()->first();
            if (!empty($reporter)) {


                $reporter_news =
                    $this->news
                    ->select($this->news_fields)
                    ->join('news_reporters', 'news_reporters.newsId', 'news.id')
                    ->where('news_reporters.reporterId', $reporter->id)
                    ->orderBy('news.id', 'desc')
                    ->take(10)
                    ->get();

                // dd($reporter_news, 'hello', round(microtime(true) - LARAVEL_START, 2));
                $data['reporter_news'] = $reporter_news;
            } else {
                $news_added_by = $news_detail->user()->first();
                if ($news_added_by) {
                    $reporter_news = $this->news
                        ->where('created_by', $news_added_by->id)
                        ->where('news.id', '!=', $news_detail->id)
                        ->orderBy('news.id', 'desc')
                        ->take(10)
                        ->get();
                    $data['reporter_news'] = $reporter_news;
                }
                // dd($reporter);
            }
        }

        // }

        $data['category'] = $category;

        // dd($data);
        return $data;

         
    }

    protected function getNewsDetail(Request $request, $slug)
    {
        // dd($slug);
        $news_detail = $this->news
            ->where('slug', $slug)
            ->where('publish_status', '1')
            ->first();
        // dd($news_detail);
        abort_if(!$news_detail, 404);

        $category = $this->category->select('id', 'slug', 'title')
            ->whereIn('id', $news_detail->category)
            ->first();
        $pool = Pool::create();
        //   dd($pool);

        // $ids = [$news_detail->id];
        // $ids = array_merge($ids, $latest_news->pluck('id')->toArray());
        // dd($ids);
        $related_news = $this->news
            ->select('id', 'title', 'img_url', 'created_at', 'reporter', 'slug', 'category', 'description')
            // ->whereNoTIn('id',   $ids)
            ->where(function ($qr) use ($news_detail) {
                $iqr = $qr;
                foreach ($news_detail->category as $cat) {
                    $iqr = $iqr->orWhereJsonContains('category', $cat);
                }
                return $iqr;
            })
            ->take(3)
            ->orderBy('created_at', 'DESC')
            ->get();
        // dd($related_news);
        // dd($category);
        // $ids =  array_merge($ids, $related_news->pluck('id')->toArray());

        // dd($category_news);

        // event(new NewsTagCountEvent($news_detail));
        $data = [
            'news_detail' => $news_detail,
            // "latest_news" => $latest_news,
            "related_news" => $related_news,
            // "category_news" => $category_news,
            "category" => $category,
        ];
        $pool[] = async(function () use ($slug, $category, $data) {
            $latest_news = $this->news->select('id', 'title', 'slug', 'publish_status')
                ->where('slug', '!=', $slug)
                ->where('publish_status', '1')
                ->orderBy('created_at', 'DESC')
                ->take(10)
                ->get();
            $category_news = $this->news
                ->select('id', 'category', 'title', 'slug', 'created_at')
                // ->whereNoTIn('id',   $ids)
                ->where('publish_status', '1')->take(6)
                ->whereJsonContains('category', $category->id)
                ->orderBy('created_at', 'DESC')
                ->get();
            return [
                "latest_news" => $latest_news,
                "category_news" => $category_news,
            ];
        })->then(function ($news) {
            $data['latest_news'] = $news['latest_news'];
            $data['category_news'] = $news['category_news'];
        });
        // $pool->add(function () use ($slug, $category, $data) {
        //     // dd($latest_news);
        // })->then(function ($data) {
        //     $data['latest_news'] = $data['latest_news'];
        //     $data['category_news'] = $data['category_news'];
        // })->catch(function (Throwable $exception) {
        //     // dd($exception);
        // });

        await($pool);
        // dd($pool);
        return view('website.news.news-detail', $data);
    }
}
