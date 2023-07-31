<?php

namespace App\Http\View\Composers;

use Illuminate\Filesystem\Cache;
use App\Models\AppSetting;
use App\Models\FrontNews;
use App\Models\Information;
use App\Models\News;
use App\Models\Video;
use App\Models\Team;
use App\Traits\SharedTrait;
use Aws\Api\Service;
use Illuminate\View\View;

class MenuComposer
{
    use SharedTrait;
    public function compose(View $view)
    {
        cache()->forget('homepage_video', 'footer_team', 'sitesetting', 'app_menu');
        $website = cache()->remember('sitesetting', 60 * 6 * 24, function () {
            return   AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        });

        // dd($header_ads);
        // select('id', 'title', 'slug', 'show_on')
        // $this->current_route = request()->route()->getName();
        $menus = $this->getMenus();

        // $header_ads = $this->getAllHeaderAndMenuAds('header');
        // $after_header_menu = $this->getAllHeaderAndMenuAds('menu');
        // $startup_ad = $this->getAllHeaderAndMenuAds('skip');
        // $bottom_ads = $this->getAllHeaderAndMenuAds('bottom');

        $header_menus = [];
        $sidebar = [];
        $footer_menus = [];
        foreach ($menus as $menuItem) {
            if ($menuItem->show_on) {
                if (in_array('header', $menuItem->show_on)) {
                    $header_menus[] = $menuItem;
                }
                if (in_array('sidebar', $menuItem->show_on)) {
                    $sidebar[] = $menuItem;
                }
                if (in_array(['useful_links','footer'], $menuItem->show_on) || in_array('footer', $menuItem->show_on)) {
                    $footer_menus[] = $menuItem;
                }
            }
        }
        $services=Information::where('publish_status','1')->orderby('position','ASC')->take(6)->pluck('title','slug');




        $team =  Team::select(
            'teams.designation_id',
            'teams.full_name',
            'teams.id',
            // "designations.title"
        )
            ->leftJoin('designations', 'designations.id', 'teams.designation_id')
            ->with('designation:id,title,position')
            ->orderBy('designations.position', 'ASC')
            ->where('show_footer', true)
            ->where('teams.publish_status', '1')
            ->get();

            $trending = FrontNews::select('id', 'slug', 'title', 'created_at', 'view_count', 'img_url')
            ->where('published_at', '>', now()->subdays(7))
            ->verifiednews()
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();
        // dd(cache()->getStore()->getFilesystem()->allFiles());
        // dd($footerVideo);
        // dd($website);
        // dd($after_header_menu);
        $view->with([
            'menus' => $menus,
            'sidebar' => $sidebar,
            'header_menus' => $header_menus,

            "footer_data" => $website,
            "footer_menus" => $footer_menus,
            "website" => $website,

            "footer_team" => $team,
            "trending" => $trending,
            "services" => $services,

        ]);
    }
}
