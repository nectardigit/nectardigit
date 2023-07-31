@extends('layouts.front')
@if (isset($service) && !empty($service))
    @section('page_title', $service->title)
@endif
@push('styles')
@endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    {{-- {{dd($service)}} --}}
    <!-- Bg Section -->
    <section class="bg-section"
        style="background-image: url('{{ asset($service->banner ?? 'images/breadcrumb.png') }}')">
        <div class="container">
            <div class="bg-section-wrap">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{!! $service->title !!}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->

    <!-- Single-service -->
    <section class="single-service mt">
        <div class="container">
            <div class="row">
                {{-- {{dd($service )}} --}}
                <div class="col-lg-8 col-md-12">
                    <div class="single-servies-img">
                        @if ($service->features)
                            <img src="{{ $service->features }}" alt="{{ $service->title }}">
                        @else
                            <img src="{{ asset('template/images/service-details.jpg') }}" alt="images">
                        @endif
                    </div>
                    <div class="single-service-content">
                        <h3>{!! $service->title !!}</h3>
                        <p>
                            {!! $service->description !!}
                        </p>
                        <section class="faq service-faq">
                            <h3>Frequently Asked Questions</h3>
                            <div class="faq-content">
                                <div class="faq-wrap">
                                    <div class="accordion" id="accordionExample">
                                        @foreach ($faq as $key => $value)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="h-{{ $key }}">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#c-{{ $key }}" aria-expanded="true"
                                                        aria-controls="c-{{ $key }}">
                                                        {!! $value->title !!}
                                                    </button>
                                                </h2>
                                                <div id="c-{{ $key }}"
                                                    class="accordion-collapse collapse @if ($key == '0')show @endif "
                                                    aria-labelledby="h-{{ $key }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <p>
                                                            {!! $value->description !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="service-sidebar-wrap">
                        @if (isset($related_services))
                            <div class="service-sidebar service-sidebar-bg">
                                <h3>Our Services</h3>
                                <ul>
                                    @foreach ($related_services as $slug => $value)
                                        <a href="{{ route('detailpage', ['slug' => $slug, 'type' => 'services']) }}">
                                            <input type="text" name="type" value="services" style="display: none">
                                            <li><button title="{{ @$value }}">{!! $value !!}</button></li>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="service-contact service-sidebar-bg">
                            <h3>Contact Us</h3>
                            <ul>
                                <li><a href="#"><i
                                            class="fa fa-map-marker"></i>{{ $contact_data->address ?? 'Kupandole, Lalitpur, Nepal' }}
                                        #{{ $contact_data->phone[0]['contact_city'] ?? 'Kathmandu' }} </a></li>
                                <li><a href="tel:{{ $contact_data->phone[0]['phone_number'] ?? '+9779807555929' }}"><i
                                            class="fa fa-phone"></i>{{ $contact_data->phone[0]['phone_number'] ?? '+9779807555929' }}</a>
                                </li>
                                <li><a href="mailto:{{ $contact_data->email ?? 'info@nectardigit.com' }}"><i
                                            class="fa fa-envelope-o"></i>{{ $contact_data->email ?? 'info@nectardigit.com' }}</a>
                                </li>
                                <li><a href="{{ env('APP_URL') ?? 'www.nectardigit.com' }}"><i class="fa fa-globe">
                                            {{ env('APP_URL') ?? 'www.nectardigit.com' }}</i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Single Service End -->
    @include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
