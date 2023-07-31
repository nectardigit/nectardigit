
@extends('layouts.front')
@section('page_title', 'Blogs')
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
                <h1>Blog</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}" title='Home'>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->
    @include('website.index.blog')
    @include('website.index.newsletter')
@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
