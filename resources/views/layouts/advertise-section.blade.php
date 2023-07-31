<div class="{{ @$advertise->columnType }} default-hide {{checkdevice(@$advertise->show_on) }}  ">
    <div class="add-one">
        <a href="{{ route("redirectAdvertise", ["r" => @$advertise->url, "path" => $advertise->id])  }}" target="_blank">

            {{-- {{ dd(@$advertise->img_url_app) }} --}}

            <x-ad-image adimage="{{ (!$device && ($advertise->show_on  == 'app' || @$advertise->img_url_app)) ?  @$advertise->img_url_app : @$advertise->img_url }}"  adtitle="{{ @$advertise->title ?? 'Capital Nepal' }}"/>
{{--             <img src="{{ !$device && ($advertise->show_on  == 'app' || @$advertise->img_url_app) ?  @$advertise->img_url_app : @$advertise->img_url }}" alt="images" class="cn-image-holder">--}}
        </a>
    </div>
</div>
