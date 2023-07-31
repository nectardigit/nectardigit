	{{-- {{dd($notice)}} --}}
@if(isset($notice))
    <!-- Skip Ads -->
    <div class="skip-ads">
        <div class="skip-ads-wrap">
            <div class="skip-ads-head">
                <img src="{{( $website->logo_url ?? 'template/images/logo.png')}}" alt="{{@$website->name ?? env('APP_NAME') ?? 'Nectar Digit'}}">
                <button type="" class="btn btn-primary">Skip</button>
            </div>
            <div class="skip-ads-col only-desktop">
                <a href="#" title=""><img src="{{(asset(@$notice->image))}}" alt="{{@$notice->title}}"></a>
            </div>
            <div class="skip-ads-col only-mobile">
                <a href="#" title=""><img src="{{(asset(@$notice->image))}}" alt="{{@$notice->title}}"></a>
            </div>
        </div>
    </div>
    <!-- Skip Ads End -->
    @endif
