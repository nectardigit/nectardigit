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
    {{-- {{dd($setting)}} --}}
    <!-- Contact Page -->
    <section class="contact-page pt">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-wrap">
                        <div class="bg-icon">
                            <i class="fa fa-map-signs"></i>
                        </div>
                        <div class="contact-icon">
                            <a href="{{@$setting->map_url}}" title="{{ @$setting->address ?? 'Kupandole, Lalitpur, Nepal' }}" target="_blank">
                                <i class="fa fa-map-signs"></i>
                            </a>
                        </div>
                        <div class="contact-content">
                            <span>Address</span>
                            <a href="{{@$setting->map_url}}" title="{{ @$setting->address ?? 'Kupandole, Lalitpur, Nepal' }}">
                                <p>
                                    {{ @$setting->address ?? 'Kupandole, Lalitpur, Nepal' }}
                                     
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-wrap">
                        <div class="bg-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="contact-icon">
                            <a href="tel:{{ $setting->phone[0]['phone_number'] ?? '+977-01-5904030' }}" title="Phone">
                            <i class="fa fa-phone"></i>
                            </a>
                        </div>
                        <div class="contact-content">
                            <span>Contact</span>
                            <a href="tel:{{ $setting->phone[0]['phone_number'] ?? '+977-01-5904030' }}" title="Phone">
                                <p> {{ $setting->phone[0]['phone_number'] ?? '+977-01-5904030' }} </p>
                            </a>
                            <a href="tel:{{ $setting->phone[1]['phone_number'] ?? '+977 9807555929' }}" title='Phone'>
                                <p> {{ $setting->phone[1]['phone_number'] ?? '+977 9807555929' }} </p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-wrap">
                        <div class="bg-icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <div class="contact-icon">
                            <a href="mailto:{{ $setting->email ?? 'nectardigit@gmail.com' }}">
                            <i class="fa fa-envelope-o"></i>
                            </a>
                        </div>
                        <div class="contact-content">
                            <span>Email</span>
                            <a href="mailto:{{ $setting->email ?? 'nectardigit@gmail.com' }}">
                                <p>{{ $setting->email ?? 'nectardigit@gmail.com' }} </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Page End -->
    {{-- {{dd($pagedata)}} --}}
    <!-- Contact Form -->
    <section class="contact-forms mt">
        <div class="container">
            {{-- <div class="main-title">
                <h2>{!! html_entity_decode(@$pagedata->short_description['en']) ?? 'Get In Touch With Us' !!}</h2>
                <p>{!! html_entity_decode(@$pagedata->description['en']) ?? 'We provide a range of IT related services at reasonable cost and with highest quality possible.' !!}</p>
                <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
            </div> --}}
            <div class="contact-form-cover">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="contact-form-img">
                            <img src="{{ asset($pagedata->featured_img ?? 'template/images/contact.png') }}"
                                alt="{{ @$pagedata->title['en'] ?? 'Contact' }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="contact-form">
                            <h3>Need assistance? please fill the form</h3>
                            <form id="formSubmit" action={{ route('contactStore') }} method="post">
                                @csrf

                                <div class="mb-3">
                                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                </div>

                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject">
                                </div>
                                <div class="mb-3">
                                    <textarea name="message" class="form-control" placeholder="Message" required></textarea>
                                </div>

                                {{-- <button id="formSubmit" type="submit" class="main-btn g-recaptcha" data-sitekey ="{{ env('GOOGLE_SITE_KEY')}}" data-callback="onSubmit">Submit Now</button> --}}
                                <div class="col-md-12 padding">
                                    <div class="form-group">
                                        {!! Form::submit('Submit', ['class' => 'g-recaptcha main-btn1', 'data-sitekey' => env('GOOGLE_SITE_KEY'), 'data-callback' => 'onSubmit', 'data-action' => 'submit']) !!}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="contact-bg-logo">
                    <i class="fa fa-comment"></i>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Form End -->
    	<!-- Map -->
		<section class="map mt">
			<iframe src="{{@$setting->embedded_url ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.566906648736!2d85.31047061458295!3d27.699777632432518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1918e77a958d%3A0x8adb3649babf6b7e!2sNectar%20Digit%20Pvt.%20Ltd.!5e0!3m2!1sen!2snp!4v1614323460222!5m2!1sen!2snp'}}" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy">
			</iframe>
		</section>
		<!-- Map End -->
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
