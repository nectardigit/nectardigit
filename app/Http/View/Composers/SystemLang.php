<?php
namespace App\Http\View\Composers;

use App\Models\AppSetting;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class SystemLang
{
    public function compose(View $view)
    {
        // cache()->forget('sitesetting');
        $website = cache()->remember('sitesetting', 60 * 6 * 24, function () {
            return   AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        });

        $_website = @$website->website_content_format;
        $app_content = @$website->website_content_item;
        // dd($app_content);
        $agent = new Agent();
        $device = $agent->isDesktop() ;
        // dd($device) ;
        
        $_locale  = $_website == "Nepali" ? 'np' : 'en';
        $_locale = session()->put('_locale', $_locale);
        $_locale = session()->get('_locale');

        $view->with([
            '_website' => $_website,
            'app_content' => $app_content,
            "_locale" => $_locale,
            'sitesetting' => $website,
            'device' => $device,
        ]);
    }
}
