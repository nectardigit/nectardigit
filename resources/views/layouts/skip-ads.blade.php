<div class="skip-ads-img {{ @$startup_ad_item->columnType }} {{ checkdevice(@$startup_ad_item->show_on) }} ">
    <a href="{{ route("redirectAdvertise", ["r" => @$startup_ad_item->url, "path" => $startup_ad_item->id])  }}" target="_blank">
        <x-ad-image adimage="{{ (!$device && ($startup_ad_item->show_on  == 'app' || @$startup_ad_item->img_url_app)) ?  @$startup_ad_item->img_url_app : @$startup_ad_item->img_url }}" adtitle="{{ @$advertise->title ?? 'Capital Nepal' }}" />

{{--        <img src="{{ $startup_ad_item->img_url }}" alt="start-up advertisement" class="img-responsive"/>--}}
    </a>
</div>
