
<!-- Faq -->
{{-- {{dd(isset($faq) && count($faq) >0)}} --}}
@if (isset($faq) && count($faq) >0))
<section class="faq mb mt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-5">
                <div class="faq-image">
                    <img src="{{config('texts.faqImage')}}" alt="images">
                </div>
            </div>
            <div class="col-lg-6 col-md-7">
                <div class="faq-content">
                    <div class="faq-wrap">
                        <div class="accordion" id="accordionExample">
                            @foreach($faq as $key=>$value)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="h={{$key}}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#c-{{$key}}" aria-expanded="true" aria-controls="c-{{$key}}">
                                       {!! html_entity_decode(@$value->title)!!}
                                    </button>
                                </h2>
                                <div id="c-{{$key}}" class="accordion-collapse collapse @if(@$key=='0')show @endif" aria-labelledby="h-{{$key}}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            {!! html_entity_decode(@$value->description)!!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
<!-- Faq End -->
