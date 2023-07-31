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
    <section class="bg-section" style="background-image: url('{{asset($pagedata->parallex_img ?? 'template/images/bg-section.jpg')}}')">

        <div class="container">
            <div class="bg-section-wrap">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" title='Home'>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Bg Section End -->

    <!-- Blog Page -->
    <section class="blog-page mt">
        <div class="container">
            {{-- <div class="main-title">
                <h2> {!! html_entity_decode($pagedata->short_description['en']) !!}</h2>
                <p>
                    {!! html_entity_decode($pagedata->description['en']) !!}
                </p>
                <span class="title-pattern"><i class="fa fa-bar-chart"></i></span>
            </div> --}}
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="grid-tab" data-bs-toggle="tab" data-bs-target="#grid" type="button"
                        role="tab" aria-controls="grid" aria-selected="true"><i class="fa fa-th"></i> Grid</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button"
                        role="tab" aria-controls="list" aria-selected="false"><i class="fa fa-list-ul"></i> List</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                @include('website.Blog_Pagination_data.blod-page-data')
            </div>
        </div>
    </section>
    {{ $blog->links() }}

    <!-- Blog Page End -->



    @include('website.index.newsletter')
@endsection
@push('scripts')
    <script>
        // $(document).ready(function() {
        //     $(document).on('click', '.pagination a', function(event) {
        //         event.preventDefault();
        //         var tab_data = $('.tab-pane.fade.show.active').attr('id');
        //         var page = $(this).attr('href').split('page=')[1];

        //         featch_data(page);

        //     });

        //     function featch_data(page) {
        //         $.ajax({
        //             // type: "GET",
        //             url: '/blog?page=' + page,
        //             // data: tab_data,
        //             success: function(html) {

        //                 $('#myTabContent').htm(html);
        //             }
        //         });
        //     }


        // });

    </script>
@endpush
