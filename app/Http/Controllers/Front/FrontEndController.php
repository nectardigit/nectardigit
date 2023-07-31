<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AppSetting;
use App\Models\Benefit;
use App\Models\Blog;
use App\Models\Career;
use App\Models\Category;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Container;
use App\Models\Counter;
use App\Models\Faq;
use App\Models\FrontNews;
use App\Models\Gallery;
use App\Models\Information;
use App\Models\Menu;
use App\Models\Notice;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Team;
use App\Models\Video;
use App\Traits\BannerNewsTrait;
use App\Traits\SharedTrait;
use Aws\Api\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Laravelium\Feed\Feed;

class FrontEndController extends Controller
{
    use SharedTrait;
    use BannerNewsTrait;

    public function __construct(FrontNews $news, Menu $category, Advertisement $advertisement)
    {
        $this->news = $news;
        $this->category = $category;
        $this->advertisement = $advertisement;
        $this->get_web();
    }

    public function home()
    {
        // ----------------------------- Slider Data ----------------------------------------------
        $sliders = Slider::select('title', 'sub_title', 'image', 'description')->where('publish_status', '1')->orderBy('position', 'ASC')->get();

        // ----------------------------- Client Data ----------------------------------------------
        $client_raw = Client::where('publish_status', '1')->where('display_home', '1')->orderBy('position', 'ASC')->get();
        // dd(isset($client_raw));
        if (isset($client_raw)) {
            foreach ($client_raw as $key => $value) {
                $client[] = [
                    'title' => $value->title,
                    'logo' => $value->logo,
                    'url' => $value->url,
                    'slug' => $value->slug,
                ];
            }
        }
        // ----------------------------- Services Data ----------------------------------------------
        $service_raw = Information::where('publish_status', '1')->where('display_home', '1')->orderBy('position', 'ASC')->get();
        // dd(isset($service_raw));
        if (isset($service_raw)) {
            foreach ($service_raw as $key => $value) {
                $service[] = [
                    'title' => $value->title,
                    'description' => $value->description,
                    'image' => $value->image,
                    'slug' => $value->slug,
                ];
            }
        }
        // ----------------------------- Benefit Data ----------------------------------------------
        $benefit_raw = Container::where('publish_status', '1')->where('type', 'benefits')->orderBy('position', 'ASC')->get();
        // dd($benefit_raw);
        if (isset($benefit_raw)) {
            foreach ($benefit_raw as $key => $value) {
                $benefit[] = [
                    'title' => $value->title,
                    'icon' => $value->icon,
                ];
            }
        }
        $blog = Blog::with(['publisher'])->where('publish_status', '1')->where('display_home', '1')->select('title', 'description', 'featured_image', 'slug', 'created_by', 'created_at')->orderby('id', 'DESC')->take(3)->get();
        // dd($blog);
        $counter = Counter::where('publish_status', '1')->first();
        // dd($counter);
        $faq = Faq::where('publish_status', '1')->where('display_home', '1')->orderby('position', 'ASC')->get();

        $videos = Video::where('publish_status', '1')->where('display_home', '1')->orderby('position', 'ASC')->first();
        $notice = Notice::where('publish_status', '1')->orderby('position', 'ASC')->first();

        $data = [
            'meta' => $this->getMetaData(),
            'sliders' => $sliders ?? null,
            'client' => $client ?? null,
            'service' => $service ?? null,
            'benefit' => $benefit ?? null,
            'blog' => $blog ?? null,
            'counter' => $counter ?? null,
            'faq' => $faq ?? null,
            'videos' => $videos ?? null,
            'notice' => $notice ?? null,
        ];
        // dd($data);
        return view('website.index', $data);
    }

    public function page($data = null)
    {
        $pagedata = Menu::where('slug', $data)->first();
        if ($data != null) {
            $pagevalue = @$pagedata->content_type;
            switch ($pagevalue) {
                case 'about':
                    $meta = $this->getMetaData($pagedata);
                    $mission = Container::where('publish_status', '1')->where('type', 'mission_vision')->orderby('position', 'ASC')->select('title', 'icon', 'description')->get();
                    $customer_satisfy = Container::where('publish_status', '1')->where('type', 'customer_satisfy')->orderby('position', 'ASC')->select('title', 'icon', 'description', 'image')->get();
                    return view('website.about', compact('pagedata', 'meta', 'mission', 'customer_satisfy'));
                    break;

                case 'services':
                    if ($pagedata->parent_id == null) {
                        $service = Information::where('publish_status', '1')->paginate(20);
                        $meta = $this->getMetaData($pagedata);
                        return view('website.all-services', compact('pagedata', 'meta', 'service'));
                    } else {
                        $servicedata = new Information();
                        $service = $servicedata->where('slug', $data)->where('publish_status', '1')->first();

                        $view_count = $service->view_count + 1;
                        $service->view_count = $view_count;
                        $service->save();

                        $related_services = $servicedata->where('slug', '!=', $data)->where('publish_status', '1')->limit(5)->orderby('id', 'DESC')->pluck('title', 'slug');
                        $meta = $this->getMetaData($service);
                        $faq = Faq::where('publish_status', '1')->orderby('position', 'ASC')->get();
                        $contact_data = AppSetting::select('address', 'phone', 'email')->first();
                        $data = [
                            'service' => $service,
                            'meta' => $meta,
                            'faq' => $faq,
                            'related_services' => $related_services,
                            'contact_data' => $contact_data,
                        ];

                        return view('website.singleservice')->with($data);
                    }

                    break;

                case 'contact':
                    $setting = AppSetting::orderBy('created_at', 'desc')->select('address', 'email', 'phone', 'map_url')->first();
                    $meta = $this->getMetaData($pagedata);
                    return view('website.contact', compact('setting', 'pagedata', 'meta'));
                    break;

                case 'gallery':
                    $gallery = Gallery::where('publish_status', '1')->orderby('id', 'DESC')->select('id', 'title', 'cover_image', 'slug')->get();
                    $meta = $this->getMetaData($pagedata);
                    return view('website.gallery', compact('gallery', 'pagedata', 'meta'));
                    break;

                case 'blog':
                    if ($pagedata->parent_id == null) {
                        $blog_data = new Blog();

                        if (request()->category) {
                            $blog = $blog_data->join('blog_categories', 'blog_categories.blog_id', 'blogs.id')
                                ->where('blog_categories.category_id', request()->category)
                                ->where('blogs.publish_status', '1')
                                ->select('blogs.*')
                                ->paginate(6);
                        } else {
                            $blog = $blog_data->with(['publisher'])
                                ->where('publish_status', '1')
                                ->when(request()->keyword, function ($q) {
                                    return $q->where('title', 'like', "%" . request()->keyword . "%");
                                })
                                ->select('title', 'description', 'featured_image', 'slug', 'created_by', 'created_at')
                                ->orderby('id', 'DESC')
                                ->paginate(6);
                        }
                        $meta = $this->getMetaData($pagedata);
                        return view('website.blog-page', compact('pagedata', 'meta', 'blog'));
                    } else {

                        $blogs = new Blog();
                        $blogdata = $blogs->with(['publisher'])->where('publish_status', '1')->where('slug', $data)->first();
                        $view_count = $blogdata->view_count + 1;
                        $blogdata->view_count = $view_count;
                        $blogdata->save();

                        $meta = $this->getMetaData($blogdata);

                        $blogtags = DB::table('blog_tag')->where('blog_id', $blogdata->id)->pluck('tag_id');
                        $relatedblog_id = DB::table('blog_tag')->whereIn('tag_id', $blogtags)->pluck('blog_id');
                        $related_blog = $blogs->with(['publisher'])->where('publish_status', '1')->where('slug', '!=', $data)->whereIn('id', $relatedblog_id)->select('title', 'featured_image', 'slug', 'created_by', 'created_at')->orderby('id', 'DESC')->take(9)->get();
                        $popularblog = $blogs->where('publish_status', '1')->where('slug', '!=', $data)->orderby('view_count', 'DESC')->select('title', 'featured_image', 'slug', 'created_at')->take(6)->get();
                        $data = [
                            'blogdata' => $blogdata,
                            'meta' => $meta,
                            'related_blog' => $related_blog,
                            'popularblog' => $popularblog,
                        ];
                        return view('website.blogdetail')->with($data);
                    }
                    break;
                case 'portfolio':
                    if ($pagedata->parent_id == null) {

                        $portfolio = Client::where('publish_status', '1')->orderby('position', 'ASC')->select('title', 'image', 'url', 'slug', 'logo')->paginate(40);;
                        $meta = $this->getMetaData($pagedata);
                        // dd($portfolio);
                        return view('website.portfolio', compact('portfolio', 'pagedata', 'meta'));
                    } else {
                        $portfolio = Client::where('publish_status', '1')->where('slug', $data)->first();
                        $meta = $this->getMetaData($portfolio);
                        return view('website.singleportfolio', compact('portfolio', 'meta'));
                    }
                case 'team':
                    $meta = $this->getMetaData($pagedata);
                    $team = Team::select(
                        'teams.*',
                    )
                        ->leftJoin('designations', 'designations.id', 'teams.designation_id')
                        ->with('designation:id,title,position')
                        ->orderBy('designations.position', 'ASC')
                        ->where('teams.publish_status', '1')
                        ->get();


                    return view('website.team', compact('pagedata', 'meta', 'team'));
                    break;
                case 'career':
                    $meta = $this->getMetaData($pagedata);
                    $careers = Career::where('publish_status', '1')->where('deadline', '>=', now())->get();
                    // dd($careers);
                    return view('website.career', compact('meta', 'pagedata', 'careers'));
                    break;

                case 'basicpage':
                    $meta = $this->getMetaData($pagedata);
                    return view('website.basicpage', compact('pagedata', 'meta'));
                    break;

                default:
                    return redirect()->route('index');
                    break;
            }
        } else {
            return redirect()->route('index');
        }
    }

    public function contactStore(Request $request)
    {

        $secret = env('GOOGLE_SECRET_KEY');
        $captcha = $request->input('g-recaptcha-response');
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
        if ($response['success']) {
            try {
                $contact = new Contact();
                $contact->name = $request->name;
                $contact->email = $request->email;
                $contact->subject = $request->subject;
                $contact->phone = $request->phone;
                $contact->message = $request->message;
                $contact->save();

                $request->session()->flash('success', 'Submitted Successfully!.');
                return back();
            } catch (\Exception $e) {
                $error = $e;

                $request->session()->flash('error', $error);
                return back();
            }
        } else {
            $request->session()->flash('error', 'Google Recapture Error!.');
            return back();
        }
        $error = null;
    }
    protected function getMetaData($data = null)
    {
        $data = $data ?? new Menu();
        $website = AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        $image = $data->image ?? $data->featured_image ?? $data->featured_img;

        $meta = [
            'meta_title' => $this->checkValidity($data->meta_title) ?? $website->meta_title ?? 'nectar-digit',
            'meta_keyword' => $this->checkValidity($data->meta_keyword) ?? $website->meta_keyword ?? 'nectar-keyword',
            'meta_description' =>  $this->checkValidity($data->meta_description) ?? $website->meta_description ?? 'nectar-description',
            'meta_keyphrase' => $this->checkValidity($data->meta_keyphrase) ?? $website->meta_keyphrase ?? 'nectar-keyphrase',
            'og_image' => create_image_url($image, 'same') ?? create_image_url($website->og_image, 'banner') ?? env('APP_URL') . '/images/logo.png',
            'og_url' => route('index'),
            'og_site_name' => $website->name,
        ];
        return $meta;
    }

    private function checkValidity($data)
    {
        return !empty($data) ? str_limit(strip_tags(html_entity_decode($data))) : null;
    }



    public function sitemap()
    {
        $sitemap = App::make("sitemap");
        $sitemap->add(URL::to('/'), date(now()), '1.0','daily');
        $menus = DB::table('menus')->where('deleted_at', null)->get();
        foreach ($menus as $menu) {
            $title  = str_replace('-', ' ', $menu->slug);
            $sitemap->add(URL::to($menu->slug), $menu->created_at, '1.0','daily');
        }
        $blogs = DB::table('blogs')->where('deleted_at', null)->orderBy('created_at', 'desc')->get();
        foreach ($blogs as $value) {
            $title = str_replace('-', ' ', $value->slug);
            $sitemap->add(URL::to($value->slug), $value->created_at, '1.0','daily');
        }

        $service = DB::table('information')->where('deleted_at', null)->orderBy('created_at', 'desc')->get();
        foreach ($service as $value) {
            $title = str_replace('-', ' ', $value->slug);
            $sitemap->add(URL::to($value->slug), $value->created_at, '1.0','daily');
        }
        $clients = DB::table('clients')->where('deleted_at', null)->orderBy('created_at', 'desc')->get();
        foreach ($clients as $value) {
            $title = str_replace('-', ' ', $value->slug);
            $sitemap->add(URL::to($value->slug), $value->created_at,' 0.9','daily');
        }
        $team = DB::table('teams')->where('deleted_at', null)->orderBy('created_at', 'desc')->get();
        foreach ($team as $value) {
            $title = str_replace('-', ' ', $value->slug);
            $sitemap->add(URL::to($value->slug), $value->created_at, '0.8','daily');
        }


        $sitemap->store('xml', 'sitemap');
        $sitemapUrl = env('APP_URL') . 'sitemap.xml';


        $url = "https://www.google.com/ping?sitemap=" . $sitemapUrl;
        $this->Submit_SiteMap($url);

        $url = "http://www.bing.com/ping?sitemap=" . $sitemapUrl;
        $this->Submit_SiteMap($url);
        // Live
        $url = "http://webmaster.live.com/ping.aspx?siteMap=" . $sitemapUrl;
        $this->Submit_SiteMap($url);

        return redirect(url('sitemap.xml'));
    }


    public function Submit_SiteMap($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode;
    }

    public function feed()
    {
        $appSetting =  AppSetting::select('*')->orderBy('id', 'desc')->first(1);
        $blog = Blog::orderBy('id', 'desc')->where('publish_status', '1')->get();
        $service = Information::orderBy('id', 'desc')->where('publish_status', '1')->get();
        return response()
            ->view('feed', compact('blog', 'service', 'appSetting'))
            ->header('Content-Type', 'application/xml');
    }
}
