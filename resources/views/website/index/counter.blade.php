{{-- {{dd($counter)}} --}}
<!-- Counter -->
<section class="counters mt">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="counter-wrap">
                    <div class="counter-icon">
                        <i class="{{@$counter->happy_client['icon']}}"></i>
                    </div>
                    <div class="counter-content">
                        <span class="counter">{{@$counter->happy_client['value']}}</span>
                        <p>Happy Clients</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="counter-wrap">
                    <div class="counter-icon">
                        <i class="{{@$counter->skil_export['icon']}}"></i>
                    </div>
                    <div class="counter-content">
                        <span class="counter">{{@$counter->skil_export['value']}}</span>
                        <p>Skilled Experts</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="counter-wrap">
                    <div class="counter-icon">
                        <i class="{{@$counter->finesh_project['icon']}}"></i>
                    </div>
                    <div class="counter-content">
                        <span class="counter">{{@$counter->finesh_project['value']}}</span>
                        <p>Finished Projects</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="counter-wrap">
                    <div class="counter-icon">
                        <i class="{{@$counter->media_post['icon']}}"></i>
                    </div>
                    <div class="counter-content">
                        <span class="counter">{{@$counter->media_post['value']}}</span>
                        <p>Media Posts</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Counter End -->
