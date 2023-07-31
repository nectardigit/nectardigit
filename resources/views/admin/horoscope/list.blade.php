@extends('layouts.admin')
@section('title', 'title')
    @push('scripts')
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/information.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#image').change(function() {
                    $('#thumbnail').removeClass('d-none');
                })
                $(document).off('click', '#add').on('click', '#add', function(e) {
                    $('#dynamic_field').append(
                        `<div class="col-md-9">
            <div class="row">
                <input type="text" class="form-control col-sm-9" name="features[]">
                <br><br>
                <button type="button" class="btn btn_remove" style="margin-top: -10px;">
                    <i class="fas fa-trash nav-icon"></i>
                    </button>
                    </div>
                    </div>`
                    );
                });
                $(document).on('click', '.btn_remove', function() {
                    $(this).closest('div').remove();
                });
            });

        </script>
    @endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('horoscope.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-2">
                            <div class="btn-group">
                                <a href="{{ route('horoscope.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' => 'Search horoscope']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-sm btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="p-1 col-lg-3">
                            <div class="card-tools">
                                @can('horoscope-create')
                                    <a href="{{ route('horoscope.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add Horoscope</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h4>Left Sided</h4>
                    <div class="row">
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                aria-orientation="vertical">
                                @foreach ($horoscopes as $key => $horoscope)
                                    <a class="nav-link" id="vert-tabs-{{ $key }}-tab" data-toggle="pill"
                                        href="#vert-tabs-{{ $key }}" role="tab" aria-controls="vert-tabs-home"
                                        aria-selected="false">{{ $key }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                @foreach ($horoscopes as $key => $horoscope)
                                    <div class="tab-pane text-left fade" id="vert-tabs-{{ $key }}" role="tabpanel"
                                        aria-labelledby="vert-tabs-{{ $key }}-tab">
                                        {{ $horoscope }}
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
