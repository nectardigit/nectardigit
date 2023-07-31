@extends('layouts.admin')
@section('title', 'Advertisement ')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Advertisement List</h3>
                    <div class="card-tools">
                        <a href="{{ route('advertisement.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-2">
                            <div class="btn-group">
                                <a href="{{ route('advertisement.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        <div class="p-1 col-lg-4">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-6 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' => 'Search Title']) !!}
                                    </div>
                                    <div class="p-1 col-lg-6 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-sm btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="p-1 col-lg-6">
                            <div class="row">

                                <div class="col-lg-6 card-tools">
                                    @can('advertisement-sort')
                                    <a href="{{ route('advertisements.sort') }}"
                                        class="btn btn-warning btn-sm btn-flat mr-2">
                                        <i class="fa fa-sort"></i> Sort Advertisement
                                    </a>
                                    @endcan

                                </div>
                                <div class="col-lg-6 card-tools">
                                    @can('advertisement-create')
                                        <a href="{{ route('advertisement.create') }}"
                                            class="btn btn-success btn-sm btn-flat mr-2">
                                            <i class="fa fa-plus"></i> Add New Advertisement
                                        </a>
                                    @endcan
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Position</th>
                                <th>Section</th>
                                <th>Direction</th>
                                <th>Clicked</th>
                                <th> Thumbnail </th>
                                <th>Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ $value->title }}</td>
                                    <td>{{ @$value->get_position->title }}</td>
                                    <td>

                                        {{ @get_title($value->get_position->get_section) }}
                                    </td>
                                    <td> {{ ucFirst($value->direction) }} </td>
                                    <td> {{ @$value->view_count }} </td>
                                    <td>
                                        @if (isset($value->title['en']))
                                            <a target="_blank" href="{{ $value->path }}">
                                                <img src="{{ $value->path }}" alt="{{ @$value->title['en'] }}"
                                                    class="img img-thumbail" style="width:60px">
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route("changeAdStatus", [$value->id, $value->publish_status]) }}" onclick=" return confirm('Are you sure want {{ $value->publish_status == '1' ? 'Unpublish' : 'Publish' }} this advertisement ? ')"
                                            class="badge badge-{{ $value->publish_status == '1' ? 'success' : 'danger' }}">
                                            {{ $value->publish_status == '1' ? 'Active' : 'Inactive' }}
                                    </a>
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            {{-- @can('advertisement-edit')
                                                <a href="{{ route('advertisement.edit', $value->id) }}"
                                                    title="Edit Advertisement" class="btn btn-success btn-sm btn-flat"><i
                                                        class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('advertisement-delete')
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['advertisement.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this Advertisement?")']) }}
                                                {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete Advertisement']) }}
                                                {{ Form::close() }}
                                            @endcan --}}
                                            <?php $userRole =  request()->user()->roles->first()->name ?>
                                            @if($userRole == 'Super Admin' || $userRole == 'Admin')
                                            @can('advertisement-edit')
                                            <a href="{{ route('advertisement.edit', $value->id) }}"
                                                title="Edit Advertisement" class="btn btn-success btn-sm btn-flat"><i
                                                    class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('advertisement-delete')
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['advertisement.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this Advertisement?")']) }}
                                            {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete Advertisement']) }}
                                            {{ Form::close() }}
                                            @endcan
                                            @elseif($userRole != 'Super Admin' && $userRole != 'Admin' && $value->publish_status == '0')
                                            @can('advertisement-edit')
                                            <a href="{{ route('advertisement.edit', $value->id) }}"
                                                title="Edit Advertisement" class="btn btn-success btn-sm btn-flat"><i
                                                    class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('advertisement-delete')
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['advertisement.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this Advertisement?")']) }}
                                            {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete Advertisement']) }}
                                            {{ Form::close() }}
                                            @endcan
                                            @endif

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
                                    Showing <strong>{{ $data->firstItem() }}</strong> to
                                    <strong>{{ $data->lastItem() }} </strong> of <strong>
                                        {{ $data->total() }}</strong>
                                    entries
                                    <span> | Takes <b>{{ round(microtime(true) - LARAVEL_START, 2) }}</b> seconds to
                                        render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{ $data->links() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
