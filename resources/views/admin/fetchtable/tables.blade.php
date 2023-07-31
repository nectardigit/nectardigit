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
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-2">
                            <div class="btn-group">
                                <a href="{{ route('fetchtable.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="  col-lg-6 col-md-6 col-sm-6">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' => 'Search title']) !!}
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat btn-sm">
                                            <i class="fa fa fa-search"></i>
                                            Filter
                                        </button>
                                        <a href="{{ route('adminGetTables') }}" class="btn btn-primary btn-flat btn-sm">Assign Tables</a>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-6 col-md-6 col-sm-6">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Table Name(Internal Database)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($database1 as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>{{ $value->$dbname1 }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('fetchrowinternal', $value->$dbname1) }}"
                                                    title="view columns of the table"
                                                    class="btn btn-primary btn-sm btn-flat"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-6 col-md-6 col-sm-6">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Table Name(External Database)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($database2 as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}.</td>
                                        <td>{{ $value->$dbname2 }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('fetchrowexternal', $value->$dbname2) }}"
                                                    title="view columns of the table"
                                                    class="btn btn-primary btn-sm btn-flat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
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
