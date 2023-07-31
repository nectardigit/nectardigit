@extends('layouts.front')
@section('page_title', @$pagedata->title['en'])
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection


@section('content')

    {{-- {{dd($pagedata)}} --}}
    <!-- Bg Section -->
    <section class="bg-section" style="background-image: url({{asset(@$pagedata->parallex_img ?? 'template/images/bg-section.jpg')}})">
        <div class="container">
            <div class="bg-section-wrap">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" title="'Nectar Digit">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ @$pagedata->title['en'] ?? 'Contact Us' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->
    @if(isset($gallery))
    <!-- Gallery Page -->
		<section class="gallery mt">
			<div class="container">
				{{-- <div class="main-title">
                    <h2>{!! html_entity_decode(@$pagedata->short_description['en']) ?? 'Get In Touch With Us' !!}</h2>
                    <p>{!! html_entity_decode(@$pagedata->description['en']) ?? 'We provide a range of IT related services at reasonable cost and with highest quality possible.' !!}</p>
                    <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
				</div> --}}
				<div class="row">
                    @foreach ($gallery as $value)
                    <div class="col-lg-3 col-md-4 col-sm-6">
						<div class="gallery-wrap">
							<div class="gallery-img">
                                <a href="{{route('detailpage',['slug'=>$value->slug,'type'=>'gallery'])}}">
                                    <button>
                                        <img src="{{(@$value->cover_image ?? 'template/images/blog1.jpg')}}" alt="{{@$value->title}}">
                                        <span>{{@$value->title}}</span>
                                    </button>
                                </a>

							</div>
						</div>
					</div>

                    @endforeach

				</div>
			</div>
		</section>
		<!-- Gallery Page End -->
        @endif
        @include('website.index.newsletter')

@endsection
@push('styles')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("formSubmit").submit();
    }
</script>

@endpush
