<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\FrontNews;
use App\Models\Menu;
use App\Models\News;
use App\Models\Team;
use App\Traits\HomepageNewsTrait;
use Illuminate\Http\Request;

class FrontCategoryController extends Controller
{
    use HomepageNewsTrait;
    public function __construct(Menu $category, FrontNews $news)
    {
        $this->category = $category;
        $this->news = $news;
    }
    public function newsCategory(Request $request, $slug)
    {
        // dd($slug);
        if ($slug == 'capital-bishesh') {
            return $this->capitalBiseshNews($request);
        }
        $categoryInfo = Menu::select('id', 'title', 'slug', 'description', 'parent_id', 'content_type', 'meta_title', 'meta_keyword', 'meta_description', 'meta_keyphrase')
            ->where('slug', $slug)
            ->where('publish_status', '1')
            ->first();
        // dd($categoryInfo);
        if (!$categoryInfo) {
            abort(404);
        }
        // dd($categoryInfo, 'hello', round(microtime(true) - LARAVEL_START, 2));
        // dd($categoryInfo);
        // $category_news = $this->category
        // ->with(['categoriesHasNews' => function ($qr) {
        //     return $qr->paginate(15);
        // }])
        // ->whereHas('categoriesHasNews', function($qr) use ($categoryInfo) {
        //     return $qr->where('categoryId', $categoryInfo->id);
        // })
        //     ->where('publish_status', '1')
        //     ->where('id', $categoryInfo->id)
        //     ->first();
        if ($categoryInfo->content_type == 'category') {

            $category_news = $this->news
                ->select(
                    'news.id',
                    'news.category',
                    'news.description',
                    'news.news_language',

                    'news.title',
                    'news.slug',
                    'news.published_at',
                    'news.meta_title',
                    'news.meta_keyword',
                    'news.meta_description',
                    'news.meta_keyphrase',
                    'news.img_url',
                    'news.created_by'
                )
                // ->whereNoTIn('id',   $ids)
                ->join('news_categories', 'news_categories.newsId', 'news.id')
                ->verifiednews()
                ->where('news_categories.categoryId', $categoryInfo->id)

                ->with('user:id,name,slug')
                ->with(['newsHasCategories' => function ($qr) {
                    return $qr->select("*")->where('publish_status', '1');
                }, 'news_reporters' => function ($qr) {
                    return $qr->select('reporters.id', 'reporters.name', 'reporters.slug', 'reporters.slug_url');
                }])
                ->whereHas('newsHasCategories', function ($qr) use ($categoryInfo) {
                    return $qr->where('categoryId', $categoryInfo->id);
                })
                // ->whereJsonContains('category', $categoryInfo->id)
                ->orderBy('news.published_at', 'DESC')
                ->paginate(15)
                ->appends($request->all());
            // dd($category_news, 'hello', round(microtime(true) - LARAVEL_START, 2));

            $data = [
                'categoryInfo' => $categoryInfo,
                'category_news' => $category_news,
            ];
            // dd($category_news);
            if ($category_news->count()) {
                $data['banner_news'] = @$category_news->take(1);
                $data['section1'] = @$category_news->skip(1)->take(3);
                $data['section2'] = @$category_news->skip(3)->take(2);
                $data['section3'] = @$category_news->skip(6)->take(3);
                $data['section4'] = @$category_news->skip(9)->take(6);
            }
            $data['meta'] = $this->getMetaData($categoryInfo);

            // dd($data['meta']);
            // dd($data['banner_news'],$data['section1']);
            // dd($data);
            return view('website/news/news-list', $data);
        }

        if ($categoryInfo->content_type != 'category') {

            $content_type = $categoryInfo->content_type;
            // dd($categoryInfo);
            switch ($content_type) {
                case 'about':
                    // dd('hsdfjdslfjsdklfs');
                    // $data = $this->getTrendingNews();
                    // dd($this->getTrendingNews());
                    $data=[
                        'categoryInfo' =>$categoryInfo
                    ];
                    return view('website.about', $data);
                    break;
                case 'contact':
                    $meta = $this->getMetaData($this->category->firstWhere('content_type', 'contact'));
                    $website = AppSetting::orderBy('created_at', 'desc')->first();
                    return view('website.contact', compact('website', 'meta'));
                    break;
                case 'blogs':
                    return view('website.blogs', compact('categoryInfo'));
                    break;
                case 'team':
                    $meta = $this->getMetaData($this->category->firstWhere('content_type', 'team'));

                    $teams =  Team::select()
                        ->leftJoin('designations', 'designations.id', 'teams.designation_id')
                        ->with('designation:id,title,position')
                        ->orderBy('designations.position', 'ASC')
                        ->where('teams.publish_status', '1')
                        ->get();
                    return view('website.team', compact('meta', 'teams'));
                    break;

                case 'basicpage':
                    return view('website.basicpage' , compact('categoryInfo'));
                    break;
                case 'advertise':
                    return view('website.advertise' , compact('categoryInfo'));
                    break;
                default:
                    return redirect()->route('index');
                    break;
            }
        }
    }

    protected function capitalBiseshNews($request)
    {
        $categoryInfo = Menu::select('id', 'title', 'slug', 'description', 'parent_id', 'content_type', 'meta_title', 'meta_keyword', 'meta_description', 'meta_keyphrase')
            ->where('slug', 'capital-bishesh')
            ->where('publish_status', '1')
            ->first();
        if (!$categoryInfo) {
            abort(404, 'Url Not found.');
        }
        $category_news = $this->news
            ->select(
                'id',
                'category',
                'description',
                'news_language',

                'title',
                'slug',
                'published_at',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'meta_keyphrase',
                'img_url',
                'created_by',
            )
            // ->whereNoTIn('id',   $ids)
            ->where('publish_status', '1')
            ->where('isSpecial', '1')
            ->with(['newsHasCategories' => function ($qr) {
                return $qr->select("*")->where('publish_status', '1');
            }])

            // ->whereJsonContains('category', $categoryInfo->id)
            ->orderBy('published_at', 'DESC')
            ->paginate(15)->appends($request->all());
            // dd($category_news);
        $data = [
            'category_news' => $category_news,
            'categoryInfo' => $categoryInfo,
        ];
        if ($category_news->count()) {
            $data['banner_news'] = @$category_news->take(1);
            $data['section1'] = @$category_news->skip(1)->take(3);
            $data['section2'] = @$category_news->skip(3)->take(2);
            $data['section3'] = @$category_news->skip(6)->take(3);
            $data['section4'] = @$category_news->skip(9)->take(6);
 
            $data['meta'] = $this->getMetaData($categoryInfo);
        }

        return view('website/news/news-list', $data);
    }
    protected function getMetaData($categoryInfo)
    {
        $website = AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        // dd($categoryInfo);
        $meta = [
            'meta_title' => @$categoryInfo->meta_title ?? @$website->meta_title ?? 'capital-nepal',
            'meta_keyword' => $categoryInfo->meta_keyword ??  @$website->meta_keyword ?? 'capital-keyword',
            'meta_description' => $categoryInfo->meta_keyword ??  @$website->meta_description ?? 'capital-description',
            'meta_keyphrase' => $categoryInfo->meta_keyword ?? @$website->meta->keyphrase ?? 'capital-keyphrase',
            'og_image' => create_image_url('logo_url', 'banner') ?? 'capital-og_image',
            'og_url' => route('newsCategory', $categoryInfo->slug),
            'og_site_name' => $website->name,
        ];

        return $meta;
    }
}
