@extends('layouts.front')
@section('page_title', @$team->full_name['en'])
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')

		<!-- Bg Section -->
        <section class="bg-section" style="background-image: url({{asset(@$banner_img ?? 'template/images/bg-section.jpg')}})">
			<div class="container">
				<div class="bg-section-wrap">
					<h1>{{@$team->full_name['en']}}</h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/')}}" title="Nectar Digit">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{@$team->full_name['en']}}</li>
						</ol>
					</nav>
				</div>
			</div>
		</section>
		<!-- Bg Section End -->
{{-- {{dd($team)}} --}}
		<!-- Team Details Page -->
		<section class="team-details mt">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-12">
						<div class="team-wrap">
							<div class="team-img">
								<img src="{{asset(@$team->image ?? 'template/images/blog1.jpg')}}" alt="{{@$team->full_name['en']}}">
								<div class="social-media">
									<ul>

                                        <li><a href="{{@$team->facebook}}" title="{{@$team->full_name['en']}}" target="_blank"><i class="fa fa-facebook"></i></a></li>


                                        <li><a href="{{@$team->twitter}}" title="{{@$team->full_name['en']}}" target="_blank"><i class="fa fa-twitter"></i></a></li>


                                        <li><a href="{{@$team->instagram}}" title="{{@$team->full_name['en']}}" target="_blank"><i class="fa fa-instagram"></i></a></li>


                                        <li><a href="{{@$team->youtube}}" title="{{@$team->full_name['en']}}" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="team-details-content">
							<h2>{{@$team->full_name['en']}}</h2>
							<span>{{@$team->designation->title['en']}}</span>
							<p>
								{!! html_entity_decode(@$team->description['en']) !!}
							</p>

							<ul class="td-contact">
								<li>
                                    @if(isset($team->phone))
									<i class="fa fa-volume-control-phone"></i>
									<b>{{@$team->phone}}</b>
                                    @endif
								</li>
								<li>
                                    @if(@isset($team->email))
									<i class="fa fa-envelope-o"></i>
									<b>{{@$team->email}}</b>
                                    @endif
								</li>
								<li>
                                    @if(isset($team->address))
									<i class="fa fa-map-signs"></i>
									<b>{{@$team->address}}</b>
                                    @endif
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Team Details Page End -->
@include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush

