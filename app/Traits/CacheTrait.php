<?php

namespace App\Traits;

trait CacheTrait
{
    public function forgetNewsCache()
    {
        cache()->forget('homepage_banner_news');
        cache()->forget('homepage_banner_news');
        cache()->forget('banner_news');
    }

    public function forgetSiteSettingCache()
    {
        cache()->forget('sitesetting');
    }

    public function forgetAdvertisementCache()
    {
        cache()->forget('afterBannerAds');
        cache()->forget('inbetweenBannerAds');

        cache()->forget('header_advertisement');
        cache()->forget('advertise_positions');
        cache()->forget('news_detail_advertise');
    }

    public function forgetAdvertisementPosition()
    {
        cache()->forget('advertise_positions');
        cache()->forget('header_advertisement');
        cache()->forget('news_detail_advertise');
    }

    public function forgetMenuCache()
    {
        cache()->forget('app_menu');
        cache()->forget('sitesetting');
    }

    public function forgetVideoCache()
    {
        cache()->forget('video');
    }

    public function forgetTeamCache()
    {
        cache()->forget('footer_team');
    }

    public function forgetHoroscopeCache()
    {
        cache()->forget('horoscope');
    }
}
