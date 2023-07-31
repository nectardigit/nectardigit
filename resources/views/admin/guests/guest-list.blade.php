@extends('layouts.admin')
@section('title', $pageTitle)
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{  $pageTitle }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('blog.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-2">
                            <div class="btn-group">
                                <a href="{{ route('guests.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm',
                                        'placeholder' => 'Search Guest By name ']) !!}
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
                                @can('guest-create')
                                    <a href="{{ route('guests.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add Guest</a>
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
                                <th> Guest name </th>
                                <th> Position </th>
                                <th> Organization </th>
                                <th> Image </th>
                                <th> Status </th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($guests) && $guests->count())

                            @foreach ($guests as $key => $value)
                                <tr>
                                    <td>{{ getPageNum($guests, $key) }}.</td>
                                    <td>
                                        {{-- dd($value) --}}
                                    {{get_guest(@$value->name)}}
                                        
                                    </td>
                                    <td>
                                      {{ get_guest_position($value, $_website) }}
                                    </td>
                                    <td>
                                        @if ($_website == 'Nepali' || $_website == 'Both')
                                        {{ @$value->organization['en'] }}
                                        @elseif ($_website == 'English' || $_website == 'Both')
                                        {{ @$value->organization['np'] }}
                                        @endif
                                    </td>
                                    {{-- dd(@$value) --}}
                                    <td>
                                        <a target="_blank" href="{{ getThumbImage(@$value->image, @$value->path) }}">
                                            <img src="{{ getThumbImage(@$value->image, @$value->path) }}"
                                                alt="{{ @@$value->title['en'] }}" class="img img-thumbail"
                                                style="width:60px">
                                        </a>
                                    </td>


                                    <td>
                                        <span
                                            class="badge badge-{{ @$value->publish_status == '1' ? 'success' : 'danger' }}">
                                            {{ @$value->publish_status == '1' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @can('guest-edit')
                                                <a href="{{ route('guests.edit', @$value->id) }}" title="Edit News"
                                                    class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('guest-delete')
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['guests.destroy', @$value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this News Guest?")']) }}
                                                {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete News ']) }}
                                                {{ Form::close() }}
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm">
                                    Showing <strong>{{ $guests->firstItem() }}</strong> to
                                    <strong>{{ $guests->lastItem() }} </strong> of <strong>
                                        {{ $guests->total() }}</strong>
                                    entries
                                    <span> | Takes <b>{{ round(microtime(true) - LARAVEL_START, 2) }}</b> seconds to
                                        render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{ $guests->links() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
