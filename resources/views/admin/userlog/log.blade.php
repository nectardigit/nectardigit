@extends('layouts.admin')
@section('title', 'Users Activity Logs')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users Activity Logs</h3>
                    <div class="card-tools">
                        <a href="{{ route('user-log.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                  <div class="row">
                    <div class="col-3 col-md-4">
                        <a href="{{ route('user-log.index') }}" class="btn btn-primary btn-flat btn-sm">
                            <i class="fas fa-sync-alt fa-sm"></i> Refresh
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                      {{Form::open(['url'=>route('user-log.index'),'method'=>'GET','class'=>'form'])}}
                      @csrf
                      <div class="input-group">
                          {{Form::select('visible',$visible,@request()->visible,['id'=>'visible','required'=>false,'class'=>'form-control d-none d-md-block','placeholder'=>'--Show--','style'=>'margin-right:10px;'])}}
                          {{Form::text('q',@request()->q,['class'=>'form-control form-control','id'=>'q','placeholder'=>'Log Message or IP..','required'=>false,'style'=>'margin-right:2px;'])}}
                          <span class="input-group-btn">
                              {{Form::button("<i class='fa fa fa-search'></i> Search",['class'=>'btn btn-primary btn-flat','type'=>'submit'])}}
                          </span>
                      </div>
                      {{Form::close()}}
                    </div>
                    <div class="col-3 col-md-4">
                        <div class="float-right">
                          <a href="{{route('clear-log')}}" onclick="return confirm('Are you sure you want to delete all logs?')">
                            <button class="btn btn-danger btn-flat btn-sm"><i class="fas fa fa-trash fa-sm"></i> Clear Logs</button>
                          </a>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-body card-format" style="overflow-x:auto;">
                    <table class="table table-striped table-hover" border="1" style="font-size:14px;" bordercolor="#e8e8e8"> {{-- table-bordered--}}
                        <thead>
                          <tr>
                            <th>Sn</th>
                            <th>IP</th>
                            <th style="width:10%;">Log Message</th>
                            <th>Hited URI</th>
                            <th>Method</th>
                            <th style="width:25%;">Agent</th>
                            <th>User</th>
                            <th align="center">Log_Generated</th>
                          </tr>
                        </thead>
                        <tbody>
                            {{-- {{dd($data[0]->log_by)}} --}}
                          @if($data)
                          @foreach($data as $key=>$value)
                              <tr>
                                  <td>{{$data->firstitem()+$key}}.</td>
                                  <td>{{$value->ip}}</td>
                                  <td>
                                      {{Str::words($value['subject'],5)}}</td>
                                  <td align="center">
                                      <span class="badge badge-{{($value->link=='')?'danger':'success'}}">
                                        @php @$data1=parse_url($value->url) @endphp
                                          {{(@$data1['path'])?$data1['path']:"DB Seeder"}}
                                      </span>
                                  </td>
                                  <td>{{$value->method}}</td>
                                  <td>{{$value->agent}}</td>
                                  <td>
                                      {{(@$value->agent =='Symfony')?'System User':@$value->log_by->name['en']}}
                                  </td>
                                  <td align="center">{{$value->created_at}}</td>
                              </tr>
                          @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-sm">
                                    Showing <strong>{{ $data->firstItem() }}</strong>  to <strong>{{ $data->lastItem() }} </strong>  of <strong> {{$data->total()}}</strong> entries
                                    <span> | Takes <b>{{ round((microtime(true) - LARAVEL_START),2) }}</b> seconds to render</span>
                                  </p>
                            </div>
                            <div class="col-md-6">
                                <span class="pagination-sm m-0 float-right">{{$data->links()}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
