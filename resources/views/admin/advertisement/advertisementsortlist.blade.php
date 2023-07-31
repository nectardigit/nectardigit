@extends('layouts.admin')
@section('title', 'Advertisement ')
@section('content')
<section class="content-header pt-0"></section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sorted Advertisement List</h3>
                <div class="card-tools">
                    <a href="{{ route('advertisements.sort') }}" type="button" class="btn btn-tool">
                        <i class="fa fa-list"></i></a>
                </div>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="p-1 col-lg-2">
                        <div class="btn-group">
                            <a href="{{ route('advertisements.sort') }}" class="btn btn-primary btn-flat btn-sm">
                                <i class="fas fa-sync-alt fa-sm"></i> Refresh
                            </a>
                        </div>
                    </div>
                    <div class="p-1 col-lg-7">
                    <form action="" class="">
                            <div class="row">
                                <div class="p-1 col-lg-4 form-group row not_shared {{ $errors->has('page') ? 'has-error' : '' }}">
                                     
                                        {{ Form::select('page', @$pages, @request()->page,  ['class' => 'form-control form-control-sm  ', 'id' => 'page', 'multiple' => false, 'placeholder' => "Choose Page", 'style' => 'width:max-content']) }}

                                        @error('page')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                     
                                </div>

                                <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                    {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' =>
                                    'Search Title']) !!}
                                </div>
                                <div class=" p-1 col-lg-4 col-md-3 col-sm-4">
                                    <button class="btn btn-primary btn-flat btn-sm">
                                        <i class="fa fa fa-search"></i>
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="p-1 col-lg-3">
                        <!-- <div class="card-tools">
                                @can('advertisement-create')
                                    <a href="{{ route('advertisement.create') }}"
                                        class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add New Advertisement</a>
                                @endcan
                            </div> -->
                    </div>
                </div>
            </div>
            <div style="overflow-x: scroll" class="card-body card-format">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Advertisement Position Title</th>
                            <th>Page</th>
                            <th> No of. Ad</th>
                            <th>Section</th>
                            <th>Status</th>
                            <th style="text-align:center;" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key=>$value)
                        <tr>
                            <td>{{$key+1}}.</td>
                            <td>{{ $value->title }}</td>

                            <td> {{ $value->page }}</td>
                            <td> {{ $value->quantity }}</td>
                            <td>
                                @if(isset($value->get_section))

                                {{get_title($value->get_section)}}

                                @endif

                            </td>

                            <td>
                                <span class="badge badge-{{ $value->publish_status=='1' ?'success':'danger' }}">
                                    {{ $value->publish_status=='1'?'Active':'Inactive' }}
                                </span>
                            </td>

                            <td>
                                <div class="btn-group">

                                    <a href="{{route('advertisement.ordering',$value->id)}}" title="Edit Advertisement Position" class="btn btn-success btn-sm btn-flat"><i class="fas fa-sort"></i></a>
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
                                <strong>{{ $data->lastItem() }} </strong> of <strong> {{ $data->total() }}</strong>
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