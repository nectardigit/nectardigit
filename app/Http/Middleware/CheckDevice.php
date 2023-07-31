<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Session;
use Jenssegers\Agent\Agent;
class CheckDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
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
