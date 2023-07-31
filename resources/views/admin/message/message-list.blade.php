@extends('layouts.admin')
@section('title', 'List Subscriber')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Messages List</h3>
                    <div class="card-tools">
                        <a href="{{ route('message.show') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header ">
                    <div class="row">

                   <div class="p-1 col-lg-2">
                   <div class="btn-group ">
                        <a href="{{ route('message.show') }}" class="btn btn-primary btn-flat btn-sm">
                            <i class="fas fa-sync-alt fa-sm"></i> Refresh
                        </a>
                    </div>
                   </div>

                    <div class="p-1 col-lg-6">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' => 'Search Email']) !!}
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-sm btn-flat">
                                            <i class="fa fa fa-search"></i>
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered--}}
                        <thead>
                            <tr>
                              <th>Sn.</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Subject</th>
                              <th>Message</th>
                              <th>Created At</th>
                              <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                              <td>{{$key+1}}.</td>
                              <td>{{$value->name}}.</td>
                              <td>{{$value->email}}</td>
                              <td>{{$value->phone}}</td>
                              <td>{{$value->subject}}</td>
                              <td style="word-break: break-all;">{{$value->message}}</td>
                              <td>{{$value->created_at}}</td>
                              <td>
                                <div class="btn-group">
                                   <a href="{{route('message.repaly',$value->id)}}" title="Repaly" class="btn btn-success btn-sm btn-flat"><i class="fas fa-reply"></i></a>
                                  {{Form::open(['method' => 'get','route' => ['message.delete', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this Message?")']) }}
                                  {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete User'])}}
                                  {{ Form::close() }}
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
                                  Showing <strong>{{ $data->firstItem() }}</strong>  to <strong>{{ $data->lastItem() }} </strong>  of <strong> {{$data->total()}}</strong> entries
                                  <span> | Takes <b>{{ round((microtime(true) - LARAVEL_START),2) }}</b> seconds to render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{$data->links()}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
