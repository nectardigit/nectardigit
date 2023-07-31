<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddToReadThisNews;
use App\Models\Menu;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsReporter;
use App\Models\NewsGuest;
use App\Models\NewsTag;
use App\Models\User;
use App\Models\Reporter;
use App\Traits\NewsStorageTrait;
use App\Traits\NewsTrait;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;


// use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Spatie\Async\Pool;
use App\Traits\FacebookTrait;
use Str;

class NewsController extends Controller
{
    use NewsTrait;
    use CacheTrait;
    use NewsStorageTrait;
    use FacebookTrait;
    public $banner_type = [
        'none' => "None",
        'full_banner' => "Full section banner news",
        'text_left' => "Text on Left side",
        'text_right' => "Text on Right side",

    ];
    public function __construct(Menu $menu, News $news, NewsCategory $news_category, NewsTag $news_tag, AddToReadThisNews $add_to_read_news, NewsReporter $news_reporter)
    {
        $this->middleware(['permission:news-list|news-create|news-edit|news-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:news-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:news-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:news-delete'], ['only' => ['destroy']]);
        $this->get_web();
        $this->news = $news;
        $this->menu = $menu;
        $this->news_category = $news_category;
        $this->news_tag = $news_tag;
        $this->add_to_read_news = $add_to_read_news;
        $this->news_reporter = $news_reporter;
        cache()->forget('homepage_category_news');
        cache()->forget('banner_news');
    }



    public function index(Request $request)
    {
        cache()->forget('all_news');
        $news = cache()->remember('all_news', 60 * 60, function () use ($request) {
            return $this->getQuery($request);
        });
        // dd($news);


        $data = [
            'news' => $news,
            'pageTitle' => "News",
        ];
        return view('admin/news/news-list', $data);
    }

    public function showReporterNews(Request $request, $id)
    {
        $reporter = User::where('id', 2)->first();
        // dd($reporter);
        cache()->forget('reporter_news');
        $news = cache()->remember('reporter_news', 60 * 60, function () use ($request, $reporter) {
            return $this->getQuery($request)->where('reporter', $reporter->id);
        });
        // dd($news);


        $data = [
            'news' => $news,
            'pageTitle' => "News",
        ];
        return view('admin/news/news-list', $data);
    }

    public function create(Request $request)
    {

        $news_category = $this->getCategory();
        $guestlist = $this->getGuest();
        $reporters = $this->getReporter();
        // dd($reporters);
        $data = [
            'newsInfo' => null,
            'pageTitle' => 'Add News',
            "reporters" => $reporters,
            // "tags" => $tags,
            "guestlist" => $guestlist,
            "news_category" => $news_category,
            "banner_type" => $this->banner_type,
        ];

        return view('admin/news/english-nepali-news-form', $data);
    }



    public function store(Request $request)
    {


        // dd($request->all());
        // dd(request()->route()->getName());
        $this->validate($request, $this->newsValidate());
        DB::beginTransaction();
        try {
            $data = $this->mapNewsData($request);
            $data['created_by'] = auth()->user()->id;
            // dd($data);
            if ($this->_website == 'Nepali') {
                $data['slug'] = date('dm') . rand(100000, 999999);
            } else if ($this->_website == 'English') {
                $data['slug'] = $this->getSlug($request->en_title ?? $request->np_title);
            } else if ($this->_website == 'Both') {
                $data['slug'] = $this->getSlug($request->en_title ?? $request->np_title);
            }
            // dd($data['slug']);

            if ($request->feature_img && !empty($request->feature_img)) {
                // dd($request->feature_img);
                $images = explode(",", $request->feature_img);
                // dd($images);
                $image = [];
                foreach ($images as $value) {
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        $image[] = getImageFromUrl($value);
                    }
                }
                if (isset($image) && count($image) > 0) {

                    foreach ($image as $img) {
                        $imageName[] = $img['image'];
                        $imagePath[] = $img['path'];
                    }
                    $data['feature_img'] = $imageName;
                    $data['feature_img_path'] = $imagePath;
                    $data['feature_img_url'] = $request->feature_img;
                }
            }

            // dd($data);
            $newsInfo = $this->news->create($data);
            // dd($newsInfo);

           
            $this->updateCategory($newsInfo, $request);
            $this->updateNewsTag($newsInfo, $request);
            $this->updateAddToReadNews($newsInfo, $request);
            $this->updateReporter($newsInfo, $request);
            DB::commit();
            if ($request->facebook_share == "1") {
                $this->facebookShare($newsInfo);
            }
            $request->session()->flash('success', 'News created successfully.');
            $this->forgetNewsCache();
            return redirect()->route('news.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->to(url()->previous());
        }
    }
    public function edit(Request $request, $id)
    {
        $newsInfo = $this->news->with(['newsHasAddToReadNews', 'newsHasCategories:id,title'])->find($id);
        // dd($newsInfo);
        if (!$newsInfo) {
            $request->session()->flash('error', 'News information not found.');
            return redirect()->route('news.index');
        }
        // dd($newsInfo);
        // $newsInfo->image_url = getFullImage($newsInfo->thumbnail, $newsInfo->path);
        // $newsInfo->image_thumb_url = getThumbImage($newsInfo->thumbnail, $newsInfo->path);
        $news_category = $this->getCategory();

        $selected_categories = $newsInfo->newsHasCategories->pluck('id');
        $guestlist = $this->getGuest();

        $reporters = $this->getReporter();
        $published_at = date('m/d/Y h:i:A', strtotime($newsInfo->published_at));

        $data = [
            'selected_categories' => $selected_categories,
            'newsInfo' => $newsInfo,
            "pageTitle" => "Update News",
            "guestlist" => $guestlist,
            "reporters" => $reporters,
            "news_category" => $news_category,
            "banner_type" => $this->banner_type,
            "news_items" => $newsInfo->newsHasAddToReadNews,
            "published_at" => $published_at,
            'update' => true
        ];
        if ($newsInfo->news_language == 'en' || $newsInfo->news_language == 'np') {
            if ($newsInfo->news_language == 'en') {
                $data['newsRoute'] = "createNewsInEnglish";
            } else {
                $data['newsRoute'] = "createNewsInNepali";
            }
            return view('admin/news/english-nepali-news-form', $data);
        }
        return view('admin/news/english-nepali-news-form', $data);
    }
    public function update(Request $request, $id)
    {

        $newsInfo = $this->news->find($id);

        if (!$newsInfo) {
            $request->session()->flash('error', 'News information not found.');
            return redirect()->route('news.index');
        }

        $this->validate($request, $this->newsValidate());


        DB::beginTransaction();
        try {
            $data = $this->mapNewsData($request);
            if ($request->feature_img && !empty($request->feature_img)) {
                // dd($request->feature_img);
                $images = explode(",", $request->feature_img);
                // dd($images);
                $image = [];
                foreach ($images as $value) {
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        $image[] = getImageFromUrl($value);
                    }
                }
                if (isset($image) && count($image) > 0) {

                    foreach ($image as $img) {
                        $imageName[] = $img['image'];
                        $imagePath[] = $img['path'];
                    }
                    $data['feature_img'] = $imageName;
                    $data['feature_img_path'] = $imagePath;
                    $data['feature_img_url'] = $images;
                }
            }

            $newsInfo->fill($data)->save();
            // $this->updateCategory($newsInfo, $request);
            // $this->updateNewsTag($newsInfo, $request);
            // $this->updateAddToReadNews($newsInfo, $request);
            $this->updateReporter($newsInfo, $request);
            DB::commit();
            $this->forgetNewsCache();
            $request->session()->flash('success', 'News updated successfully.');
            return redirect()->route('news.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->to(url()->previous());
        }
    }
    public function destroy($id)
    {

        $newsinfo = $this->news->destroy($id);
        $this->forgetNewsCache();


        return redirect()->route('news.index');
    }
    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = $this->news->where('slug', $slug)->first();
        if ($find) {
            $slug = $slug . '-' . rand(1111, 9999);
        }
        return $slug;
    }
}
