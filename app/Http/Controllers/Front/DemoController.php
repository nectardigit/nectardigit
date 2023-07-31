<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\News;
use App\Models\Tag;
use App\Models\Video;
use App\Models\AdvertisementPosition;
use App\Models\Advertisement;
use App\Traits\HomepageNewsTrait;
use App\Traits\SharedTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Session;
use Jenssegers\Agent\Agent;
class DemoController extends Controller
{
    use SharedTrait;
    use HomepageNewsTrait;
    public function __construct(News $news, Menu $category, AdvertisementPosition $ad_position)
    {
        $this->news = $news;
        $this->category = $category;
        $this->ad_position = $ad_position;
    }
    public function home(Request $request){

        $homepage_sections = $this->category
        ->select('id', 'title', 'slug', 'show_on', 'content_type')
        ->with(['categoriesHasAdvertisementPosition' => function ($qr) {
            return $qr->select("*")->where('publish_status', '1');
        }])
        ->where('publish_status', '1')
        ->get()
        ->map(function ($qr) {
            return $qr->setRelation('categoriesHasAdvertisementPosition', $qr->categoriesHasAdvertisementPosition->take(5));
        });
        // dd($homepage_sections);
        $artha_news_advertisement = $this->getArthaNewsAdvertisement($homepage_sections);
    }
    protected function getArthaNewsAdvertisement($homepage_sections)
    {
        $arthaCat = $homepage_sections->where('id', 3)->first();
        // dd($arthaCat);

        $artha = @$arthaCat->categoriesHasAdvertisementPosition->toArray();
        // dd($artha);
        $artha_ad = [];
        foreach ($artha as $position) {
            $ad = Advertisement::where('position',$position['id'])->first();
            $artha_ad = $ad;
        }
        
        dd($artha_ad);

        return $data = [
            "artha_ad" => $artha_ad,
        ];
    }

    public function testDevice(Request $request){
        // dd($request->all());
        $agent = new Agent();
        dd($agent->isPhone());
        dd( $agent->browser());
      

    }
    public function Geofinder($request)
	{
		$key = Cookie::get('gd__');
		$ip  = $request->ip();

		if ($ip == "127.0.0.1") {
			$ip = "103.10.29.84";
		}


		if (!$key) {
			$clientInfo = Session::get('geo_data');

			if (!$clientInfo) {
				$key = \Str::random(30);
				$client = new \GuzzleHttp\Client();
				$response = $client->request('GET', 'http://ip-api.com/json/' . $ip);
				$data = $response->getBody()->getContents();
				$client_data = json_decode($data);
				$agent = new Agent();
				$data = $this->mapData($client_data, $key, $agent->device(), $agent->browser(), $ip);
				Session::put('geo_data',  $data);
				Cookie::queue('gd__', $key, 1440);
				\App\Model\Admin\WebVisitor::create($data);
			} else if ($clientInfo) {
				if (!isset($clientInfo['key'])) {
					$key = \Str::random(30);
					$clientInfo['key'] = $key;
					Session::put('geo_data',  $clientInfo);
				}
				Cookie::queue('gd__', $clientInfo['key'], 1440);
			}
		} else if ($key) {
			$clientInfo = Session::get('geo_data');
			if (!$clientInfo) {
				$client_data = \App\Model\Admin\WebVisitor::where('key', $key)->first();
				if ($client_data) {
					$data = $this->mapData($client_data, $key, $client_data->device, $client_data->browser, $ip);
					Session::put('geo_data',  $clientInfo);
				}
			}
		}
	}


	public function mapData($client_data, $key, $device, $browser, $ip)
	{
		return $data = [
			'ip_address'        => @$ip,
			'country'           => @$client_data->country,
			'country_code'      => @$client_data->countryCode,
			'region'            => @$client_data->region,
			'region_name'       => @$client_data->regionName,
			'city'              => @$client_data->city,
			'key'               => @$key,
			'latitude'          => @$client_data->lat,
			'longitude'         => @$client_data->lon,
			'timezone'          => @$client_data->timezone,
			'isp'               => @$client_data->isp,
			'isp_provider'      => @$client_data->org,
			'isp_provider_as'   => @$client_data->as,
			'device'            => $device,
			'browser'           => $browser,
		];
	}
}
