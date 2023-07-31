@extends('layouts.admin')
@section('title', 'Application')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Application List</h3>
                    <div class="card-tools">
                        <a href="{{ route('application.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-10">
                            <div class="btn-group">
                                <a href="{{ route('application.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        {{-- <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('keyword', $notices , @request()->keyword, ['class' => 'form-control select2', 'placeholder' =>
                                        'Search Title']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}

                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered --}}
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Applied For</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($applications->career) }} --}}
                            @if(isset($applications))
                            @foreach ($applications as $key => $value)

                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->mobile }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ @$value->careers->title }}</td>
                                    <td>
                                        @if ($value->verified)
                                        <span class="badge badge-pill badge-success">Verified</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">Not-Verified</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @can('application-show')
                                                <a href="{{ route('application.show', $value->id) }}" title="show application"
                                                    class="btn btn-dark btn-sm btn-flat"><i class="fas fa-eye"></i></a>
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
                                    Showing <strong>{{ $applications->firstItem() }}</strong> to
                                    <strong>{{ $applications->lastItem() }} </strong> of <strong>
                                        {{ $applications->total() }}</strong>
                                    entries
                                    <span> | Takes <b>{{ round(microtime(true) - LARAVEL_START, 2) }}</b> seconds to
                                        render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{ $applications->links() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
