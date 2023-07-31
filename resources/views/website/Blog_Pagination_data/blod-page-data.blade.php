<div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
    <div class="view-list grid-view">
        <div class="row">
            {{-- {{dd($blog[0]->featured_image)}} --}}
            @if (isset($blog))
                @foreach ($blog as $value)

                    <div class="col-lg-4 col-md-6">
                        <div class="blog-wrap">
                            <div class="blog-img">
                                <img src="{{ asset(@$value->featured_image ?? 'template/images/blog1.jpg') }}"
                                    alt="{{ @$value->title ?? 'Blog' }}">
                            </div>
                            <div class="blog-content">
                                <a href="{{ route('detailpage', ['type' => 'blog', 'slug' => $value->slug]) }}">
                                    <h3><button title="{{ $value->title }}">{!! html_entity_decode($value->title) !!}</button>
                                    </h3>
                                </a>
                                <ul>
                                    <li><i
                                            class="fa fa-calendar"></i>{{ date('F jS, Y', strtotime($value->created_at)) }}
                                    </li>
                                    <li><i class="fa fa-user"></i>{{ $value->publisher->name['en'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif


        </div>
    </div>
</div>
<div class="tab-pane fade " id="list" role="tabpanel" aria-labelledby="list-tab">
    <div class="view-list list-view">
        <div class="row">
            @if (isset($blog))
                @foreach ($blog as $value)

                    <div class="col-lg-12">
                        <div class="blog-wrap">
                            <div class="blog-img">
                                <img src="{{ asset(@$value->featured_image ?? 'template/images/blog1.jpg') }}"
                                    alt="{{ @$value->title ?? 'Blog' }}">

                            </div>
                            <div class="blog-content">
                                <a href="{{ route('detailpage', ['type' => 'blog', 'slug' => $value->slug]) }}">
                                    <h3><button title="{{ $value->title }}">{!! html_entity_decode($value->title) !!}</button>
                                    </h3>
                                </a>
                                <ul>
                                    <li><i
                                            class="fa fa-calendar"></i>{{ date('F jS, Y', strtotime($value->created_at)) }}
                                    </li>
                                    <li><i class="fa fa-user"></i>{{ $value->publisher->name['en'] }}
                                    </li>
                                </ul>
                                <p>
                                    {!! html_entity_decode(limit_words($value->description, 20)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

    </div>
</div>
