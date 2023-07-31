@extends('layouts.admin')
@section('title', 'Teams')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Team List</h3>
                    <div class="card-tools">
                        <a href="{{ route('team.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-2">
                            <div class="btn-group">
                                <a href="{{ route('team.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control', 'placeholder' =>
                                        'Search Title']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="p-1 col-lg-3">
                            <div class="card-tools">
                                @can('team-create')
                                    <a href="{{ route('team.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add New Team</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered--}}
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Team</th>
                            <th>Image</th>
                            <th>Status</th>
                            @canany(['team-edit','team-delete'])
                                <th style="text-align:center;" width="10%">Action</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key=>$value)
                            {{-- {{ dd($value->image) }} --}}
                            <tr>
                                <td>{{$key+1}}.</td>
                                <td>{{ @$value->full_name['en'] }} <br> {{ @$value->full_name['np'] }}</td>
                                <td>
                                    <img src="{{ create_image_url($value->image)}}"
                                         alt="{{ @$value->title}}" class="img img-thumbail" style="width:60px">

                                </td>
                                <td>
                                    <label class="toggel_switch">
                                        <input class="publish_status" data-id="{{@$value->id}}" type="checkbox" @if($value->publish_status == '1') checked @endif >
                                        <span class="slider round"></span>
                                      </label>
                                {{-- <span class="badge badge-{{ $value->publish_status=='1' ?'success':'danger' }}">
                                {{ $value->publish_status=='1'?'Active':'Inactive' }}
                                </span> --}}
                                </td>

                                <td>
                                    <div class="btn-group">
                                        @can('team-edit')
                                            <a href="{{route('team.edit',$value->id)}}" title="Edit Team"
                                               class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('team-delete')
                                            {{Form::open(['method' => 'DELETE','route' => ['team.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this Team?")']) }}
                                            {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete Team '])}}
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
                                    Showing <strong>{{ $data->firstItem() }}</strong> to
                                    <strong>{{ $data->lastItem() }} </strong> of <strong> {{$data->total()}}</strong>
                                    entries
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
@push('scripts')
<script>
    $(function() {
      $('.publish_status').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
          var data = {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id,
                    };
          $.ajax({
              type: "POST",
              url: "{{route('team.changeStatus')}}",
              data: data,
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
  </script>
@endpush

