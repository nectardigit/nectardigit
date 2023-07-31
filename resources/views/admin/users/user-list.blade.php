@extends('layouts.admin')
@section('title', 'List Users')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User List</h3>
                    <div class="card-tools">
                        <a href="{{ route('users.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="btn-group">
                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-flat btn-sm">
                            <i class="fas fa-sync-alt fa-sm"></i> Refresh
                        </a>
                    </div>
                    <div class="card-tools">
                        @can('user-create')
                        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                            <i class="fa fa-plus"></i> Add New User</a>
                        @endcan
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Mobile</th>
                                <th>User Role</th>
                                <th>News</th>
                                <th>Status</th>
                                <th>Updated</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            
                            {{-- @if($value $userRole ) --}}
                            <tr>
                              <td>{{$key+1}}.</td>
                              <td>{{ @$value->name['np'] }}</td>
                              <td>{{ $value->email }}</td>
                              <td>{{$value->mobile}}</td>
                              <td>
                                @if(!empty($value->getRoleNames()))
                                    @foreach($value->getRoleNames() as $v)
                                        <label class="badge badge-primary">{{ $v }}</label>
                                    @endforeach
                                @endif
                              </td>
                              <td>
                                  <a href="{{ route('usersNews', $value->id) }}" target="_blank" class="badge badge-info">{{ $value->total_news }}</a>
                              </td>
                              <td>
                                <span class="badge badge-{{ $value->publish_status==0 ?'danger':'success' }}">
                                {{ $value->publish_status==1?'Active':'Inactive' }}
                                </span>
                              </td>
                              <td>{{ $value->updated_at ? @$value->updated_at->format('Y-m-d') : ''}}</td>
                              <td>
                                <div class="btn-group">
                                  <a href="{{route('users.show',$value->id)}}" title="View Detail"><button class="btn btn-primary btn-sm btn-flat"><i class="fas fa-eye"></i></button></a>
                                  @can('user-edit')
                                  <a href="{{route('users.edit',$value->id)}}" title="Edit User" class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                  @endcan
                                  @can('user-delete')
                                  {{Form::open(['method' => 'DELETE','route' => ['users.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this User?")']) }}
                                  {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete User'])}}
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
