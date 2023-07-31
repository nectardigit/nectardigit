@extends('layouts.front')
@section('page_title', $pagedata->title['en'])
@push('styles')
@endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <!-- Bg Section -->
    <section class="bg-section" style="background-image: url({{ asset(@$pagedata->parallex_img ?? 'template/images/career.jpg') }})">
        <div class="container">
            <div class="bg-section-wrap">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" title="Home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                        @if (isset($blogdata)){{ $blogdata->title }} @else
                            @endif Career
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->

    <section class="career mt mb">
        <div class="container">
            <div class="main-title">
                <h2>{!! html_entity_decode($pagedata->short_description['en']) !!}</h2>
                <p>{!! html_entity_decode($pagedata->description['en']) !!}</p>
                <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
            </div>
            {{-- {{ dd($pagedata }} --}}
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    @if(isset($careers) && count($careers))

                    @foreach ($careers as $key => $career)
                        <div class="career-post">
                            <div class="career-icon">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <div class="career-content">
                                <h3><a href="{{ route('front.careerDetails',$career->slug) }}">{{ $career->title }}</a></h3>
                                <ul>
                                    <li>
                                        <div class="ca-icon">
                                            <i class="fa fa-calendar-check-o"></i>
                                            <b>Deadline:</b>
                                        </div>
                                        <p>
                                            {{ $career->deadLine->format('l jS \\of F , Y') }}

                                        </p>
                                    </li>
                                    <li>
                                        <div class="ca-icon">
                                            <i class="fa fa-graduation-cap"></i>
                                            <b>Education:</b>
                                        </div>
                                        <p>
                                            {{ $career->qualification }}
                                        </p>
                                    </li>
                                    <li>
                                        <div class="ca-icon">
                                            <i class="fa fa-briefcase"></i>
                                            <b>Work Experience:</b>
                                        </div>
                                        <p>
                                            {{ $career->experience }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach

                    @else
                        <h2> <c> WE DON'T HAVE ANY VACANCY FOR NOW. </c> </h2>
                    @endif

                </div>
                @if(isset($careers) && count($careers)>0)
                <div class="col-lg-5 col-md-12">
                    <div class="career-images">
                        <img src="{{ asset(@$pagedata->featured_img ?? 'template/images/careers.png') }}" alt="{{ $pagedata->title['en'] }}">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>


@endsection
