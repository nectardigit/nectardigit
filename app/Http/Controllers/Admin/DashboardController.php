<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Information;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Menu;
use App\Models\Team;
use App\Models\News;
use App\Models\NewsGuest;
use App\Models\Profile;
use App\Models\Reporter;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {

        $count_data['admin'] = User::whereHas('roles', function ($query) {
            $query->where('name','=', 'Admin');
        })
        ->where('publish_status', '1')->count();

        $count_data['user'] = User::where('type', 'user')->where('publish_status', '1')->count();
        $count_data['totalslider'] = Slider::all()->count();
        $count_data['published_slider'] = Slider::where('publish_status','1')->count();
        $count_data['unpublished_slider'] = Slider::where('publish_status','0')->count();

        $count_data['team'] = Team::where('publish_status', '1')->count();
        $userRole = request()->user()->roles->first()->name;


        $count_data['totalblog'] = Blog::all()->count();
        $count_data['published_blog'] = Blog::where('publish_status', '1')->count();
        $count_data['unpublished_blog'] = Blog::where('publish_status', '0')->count();

        $count_data['totaltestimonial'] = Testimonial::all()->count();
        $count_data['published_testimonial'] = Testimonial::where('publish_status', '1')->count();
        $count_data['unpublished_testimonial'] = Testimonial::where('publish_status', '0')->count();

        $count_data['totalteam'] = Team::all()->count();
        $count_data['published_team'] = Team::where('publish_status', '1')->count();
        $count_data['unpublished_team'] = Team::where('publish_status', '0')->count();


        $data = [
            'count_data' => $count_data,
            "userRole" => $userRole,
        ];

        return view('admin.dashboard')->with($data);
    }
}
