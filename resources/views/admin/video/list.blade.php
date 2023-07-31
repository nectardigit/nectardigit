@extends('layouts.admin')
@section('title', 'Videos')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Video List</h3>
                    <div class="card-tools">
                        <a href="{{ route('video.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-2">
                            <div class="btn-group">
                                <a href="{{ route('video.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' => 'Search Title']) !!}
                                    </div>
                                    <div class="p-1  col-lg-4 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat btn-sm"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="p-1 col-lg-3">
                            <div class="card-tools">
                                @can('video-create')
                                    <a href="{{ route('video.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add New video</a>
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
                                <th>title</th>
                                <th> URL </th>
                                <th> Video Origin </th>
                                <th> Display Home </th>
                                <th>Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)

                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ $value->title['np']}}</td>
                                    <td>{{ $value->url}}</td>
                                    <td><span class="{{ $value->origin == 'youtube' ? 'badge badge-warning' : 'badge badge-primary'}}">{{ $value->origin}}</span></td>

                                    <td>
                                        <label class="toggel_switch">
                                            <input class="display_home" data-id="{{@$value->id}}" type="checkbox" @if($value->display_home == '1') checked @endif >
                                            <span class="slider round"></span>
                                          </label>
                                        {{-- <span class="badge badge-{{ $value->publish_status == '1' ? 'success' : 'danger' }}">
                                            {{ $value->publish_status == '1' ? 'Active' : 'Inactive' }}
                                        </span> --}}
                                    </td>
                                    <td>
                                        <label class="toggel_switch">
                                            <input class="publish_status" data-id="{{@$value->id}}" type="checkbox" @if($value->publish_status == '1') checked @endif >
                                            <span class="slider round"></span>
                                          </label>
                                        {{-- <span class="badge badge-{{ $value->publish_status == '1' ? 'success' : 'danger' }}">
                                            {{ $value->publish_status == '1' ? 'Active' : 'Inactive' }}
                                        </span> --}}
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            @can('video-edit')
                                                <a href="{{ route('video.edit', $value->id) }}" title="Edit video"
                                                    class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('video-delete')
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['video.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this video?")']) }}
                                                {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete video ']) }}
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
              url: "{{route('video.changeStatus')}}",
              data: data,
              success: function(data){
                console.log(data.success)
              }
          });
      })
      $('.display_home').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
          var data = {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id,
                    };
          $.ajax({
              type: "POST",
              url: "{{route('video.changedisplayhome')}}",
              data: data,
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
  </script>
@endpush


