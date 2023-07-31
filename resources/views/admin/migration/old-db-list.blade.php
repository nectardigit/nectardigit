@extends('layouts.admin')
@section('title', 'Database Table List ')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Database Table List</h3>
                    <div class="card-tools">
                        <a href="{{ route('fetchtable.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i>
                        </a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        {{-- <div class="p-1 col-lg-2">
                            <div class="btn-group">
                                <a href="{{ route('fetchtable.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div> --}}
                        <div class="p-1 col-lg-7">
                            <a href="{{ route('migration.create') }}" class="btn btn-primary btn-flat btn-sm">
                                <i class="fas fa-plus fa-sm"></i> Add Database
                            </a>
                            {{-- <a href="{{ route('migration.create') }}" class="btn btn-primary btn-flat btn-sm">
                                <i class="fas fa-plus fa-sm"></i> Add Database
                            </a> --}}
                            {{-- <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-6 col-md-6 col-sm-6">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control', 'placeholder' => 'Search title']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat">
                                            <i class="fa fa fa-search"></i>
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Website url</th>
                                    <th>Content Api url</th>
                                    <th>Framework </th>
                                    <th>Content</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($old_db as $key => $value)
                              
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>{{ @$value->url }}</td>
                                        <td>{{ @$value->api_url }}</td>
                                        <td>{{ @$value->framework }}</td>
                                        <td>{{ @$value->content_type }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('migration.edit', $value->id) }}"
                                                    title="view columns of the table"
                                                    class="btn btn-primary btn-sm btn-flat">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @if($value->content_type != 'images')
                                                <a href="{{ route('migration.show', $value->id) }}"
                                                    title="view columns of the table"
                                                    class="btn btn-primary btn-sm btn-flat">
                                                    <i class="fas fa-cogs"></i>
                                                </a>
                                                @elseif($value->content_type == 'images')
                                                <a href="{{ route('updateImageName', $value->id) }}"
                                                    title="view columns of the table"
                                                    class="btn btn-primary btn-sm btn-flat">
                                                    <i class="fas fa-cogs"></i>
                                                </a>
                                                @endif 
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                     
                </div>
            </div>
        </div>
    </section>
@endsection
