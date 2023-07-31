<?php

namespace App\Traits;

use GuzzleHttp\Client as guzzle;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon as Carbon;

trait FacebookTrait
{

    public function facebookShare($news)
    {
        $facebookPageId = '443156229373913';
        $longAccessPageToken = 'EAAG8OiTceJEBAOgnPZBP81jVMZBDKBKnOPdw3QN8xM5uw2FvzXMzt9ZBNaPFjoCIWuaLoEdYMoA702gjLj1CwHLkty5atNQM82q0Q3QhZCmohnt5BwnFj13V6hOIVYZBid7ZBVwsNk0uo4NQjXR0K7vRo3gPlF4E8pQbTCTNZCzawZDZD';
        if ($this->checkNewsValidity($news)) {
            $response = Http::post("https://graph.facebook.com/$facebookPageId/feed", [
                'message' => $news->title['np'],
                'link' => route('newsDetail', $news->slug),
                'access_token' => $longAccessPageToken
            ]);
            $scrape = Http::post("https://graph.facebook.com/?scrape=true&id=" . route('newsDetail', $news->slug), [
                'message' => $news->title['np'],
                'link' => route('newsDetail', $news->slug),
                'access_token' => $longAccessPageToken
            ]);
            return $response;
        }
        return false;
    }

    public function checkNewsValidity($news)
    {
        $scheduled = $news->published_at->lt(Carbon::now());
        $publish_status = $news->publish_status;
        if ($publish_status && $scheduled) {
            return true;
        }
        return false;
    }
}
