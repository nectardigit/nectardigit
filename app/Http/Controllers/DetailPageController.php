<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Blog;
use App\Models\Career;
use App\Models\Category;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Information;
use App\Models\Menu;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPageController extends Controller
{
    public function detailpage($type, $slug)
    {
        // dd($slug);
        $page = $type;

        if ($slug != null) {
            switch ($page) {
                case 'services':
                    $data = $this->service($slug);
                    return view('website.singleservice')->with($data);
                    break;
                case 'blog':
                    $data = $this->blog($slug);
                    $banner_img = Menu::where('slug', 'blog')->pluck('parallex_img')->first();
                    $data['banner_img'] = $banner_img;
                    // dd($banner_img);
                    return view('website.blogdetail')->with($data);
                    break;
                case 'portfolio':
                    $data = $this->portfolio($slug);
                    return view('website.singleportfolio')->with($data);
                    break;
                case 'team':
                    $data = $this->team($slug);
                    $banner_img = Menu::where('slug', 'team')->pluck('parallex_img')->first();
                    $data['banner_img'] = $banner_img;
                    return view('website.singleteam')->with($data);
                    break;
                case 'gallery':
                    $data = $this->gallery($slug, request()->id);
                    $banner_img = Menu::where('slug', 'gallery')->pluck('parallex_img')->first();
                    $data['banner_img'] = $banner_img;

                    return view('website.singlegallery')->with($data);
                    break;
                case 'career':
                    $data = $this->career($slug);
                    $banner_img = Menu::where('slug', 'career')->pluck('parallex_img')->first();
                    $data['banner_img'] = $banner_img;
                    return view('website.careerdetails')->with($data);
                    break;

                default:
                    return redirect(url('/'));
                    break;
            }
        }
    }
    public function service($slug)
    {
        $servicedata = new Information();
        $service = $servicedata->where('slug', $slug)->where('publish_status', '1')->firstorfail();
        $view_count = $service->view_count + 1;
        $service->view_count = $view_count;
        $service->save();

        $related_services = $servicedata
            ->where('slug', '!=', $slug)
            ->where('publish_status', '1')
            ->limit(5)
            ->orderby('id', 'DESC')
            ->pluck('title', 'slug');
        $meta = $this->getMetaData($service);
        $faq = Faq::where('publish_status', '1')
            ->orderby('position', 'ASC')
            ->get();
        $contact_data = AppSetting::select('address', 'phone', 'email')->first();
        $data = [
            'service' => $service,
            'meta' => $meta,
            'faq' => $faq,
            'related_services' => $related_services,
            'contact_data' => $contact_data,
        ];

        return $data;
    }
    public function blog($slug)
    {
        $blogs = new Blog();
        $blogdata = $blogs->with(['publisher'])->where('publish_status', '1')->where('slug', $slug)->first();
        $view_count = $blogdata->view_count + 1;
        $blogdata->view_count = $view_count;
        $blogdata->save();

        $meta = $this->getMetaData($blogdata);

        // $tags = Tag::where('publish_status', '1')->orderBy('id', 'DESC')->get();
        // $tags = Tag::pluck('title', 'id');

        $blogtags = DB::table('blog_tag')->where('blog_id', $blogdata->id)->pluck('tag_id');
        $relatedblog_id = DB::table('blog_tag')->whereIn('tag_id', $blogtags)->pluck('blog_id');
        // dd($relatedblog_id);
        $related_blog = $blogs->with(['publisher'])->where('publish_status', '1')->where('slug', '!=', $slug)->whereIn('id', $relatedblog_id)->select('title', 'featured_image', 'slug', 'created_by', 'created_at')->orderby('id', 'DESC')->take(9)->get();
        // dd($related_blog);
        $blogcategory = Category::where('publish_status', '1')->orderby('position', 'ASC')->pluck('title', 'id');
        // $popularblog = $blogs->where('publish_status', '1')->where('slug', '!=', $slug)->orderby('view_count', 'DESC')->select('title', 'featured_image', 'slug', 'created_at')->take(6)->get();
        $data = [
            'blogdata' => $blogdata,
            'meta' => $meta,
            'related_blog' => $related_blog,
            // 'popularblog' => $popularblog,
            'blogcategory' => $blogcategory,
        ];
        return $data;
    }
    public function portfolio($slug)
    {
        $portfolio = Client::where('publish_status', '1')->where('slug', $slug)->first();
        $view_count = $portfolio->view_count + 1;
        $portfolio->view_count = $view_count;
        $portfolio->save();
        $meta = $this->getMetaData($portfolio);
        $data = [
            'portfolio' => $portfolio,
            'meta' => $meta,
        ];
        return $data;
    }
    public function team($slug)
    {
        $team = Team::with('designation')->where('publish_status', '1')->where('slug', $slug)->firstorfail();
        $view_count = $team->view_count + 1;
        $team->view_count = $view_count;
        $team->save();
        $meta = $this->getMetaData($team);
        $data = [
            'team' => $team,
            'meta' => $meta,
        ];
        return $data;
    }
    public function gallery($data, $id)
    {
        $gallery = Gallery::where('publish_status', '1')->where('id', $id)->first();
        $meta = $this->getMetaData($gallery);
        $data = [
            'gallery' => $gallery,
            'meta' => $meta,
        ];
        return $data;
    }

    public function career($data)
    {
        $career = Career::where('slug', $data)
            ->whereDate('deadLine', '>=', today())
            ->where('publish_status', 1)
            ->firstorfail();
        $meta = $this->getMetaData($career);
        // dd($career);
        $data = [
            'career' => $career,
            'meta' => $meta,
        ];
        return $data;
        // return
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
}
