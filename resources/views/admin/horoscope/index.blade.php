@extends('layouts.admin')
@section('title', 'राशिफल')
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
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered --}}
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Rasifal Type </th>
                                <th> Publish Date  </th>
                                <th> Added Date  </th>
                                <th>Status </th>
                                
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($horoscopes as $key => $value)

                                <tr>
                                    <td>{{ $key +1 }}</td>
                                    <td>{{ ucFirst($value->type) }}</td>
                                    <td>
                                        @if($value->type == 'daily')
                                        {{ datenep($value->published_at) }} 
                                        @elseif ($value->type == 'yearly')
                                        {{-- {{ dd($value) }} --}}
                                        {{ @$value->year }} 
                                        @elseif($value->type == 'monthly')
                                        {{ @$value->year }}, {{ @$months[$value->month] }}
                                        @elseif($value->type == 'weekly')
                                        {{-- {{ dd($value) }} --}}
                                        {{ @$value->startWeekDay }}, {{ @$value->endWeekDay }}
                                        @endif
                                    </td>
                                    <td>{{ $value->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $value->publish_status ? 'success' : 'info' }}">{{ $value->publish_status ? 'Active' : "Inactive" }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @canany('horoscope-edit','horoscope-update')

                                            <a href="{{ route('horoscope.edit', $value->id) }}" title="Edit horoscope"
                                                class="btn btn-success btn-sm btn-flat">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @endcanany
                                            @can('news-delete')
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['horoscope.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this horoscope?")']) }}
                                                {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete News ']) }}
                                                {{ Form::close() }}
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm">
                                    Showing <strong>{{ $horoscopes->firstItem() }}</strong> to
                                    <strong>{{ $horoscopes->lastItem() }} </strong> of <strong>
                                        {{ $horoscopes->total() }}</strong>
                                    entries
                                    <span> | Takes <b>{{ round(microtime(true) - LARAVEL_START, 2) }}</b> seconds to
                                        render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{ $horoscopes->links() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
