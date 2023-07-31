@extends('layouts.admin')
@section('title', 'Sliders')

@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sliders List</h3>
                    <div class="card-tools">
                        <a href="{{ route('slider.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="btn-group col-lg-1">
                            <a href="{{ route('slider.index') }}" class="btn btn-primary btn-flat btn-sm">
                                <i class="fas fa-sync-alt fa-sm"></i> Refresh
                            </a>
                        </div>
                        <div class="col-lg-7">
                            <form action="{{route('slider.index')}}" method="get">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' => 'Search Title']) !!}
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('status', ['1'=> 'Published', '0'=>'Unpublished'], @request()->status, ['class' => 'form-control form-control-sm', 'placeholder' => 'Select Publish Status']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-sm btn-primary btn-flat"><i
                                                class="fa fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-tools float-right">
                                @can('slider-create')
                                    <a href="{{ route('slider.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> New Slider</a>
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
                                <th>Slider</th>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Position Number</th>
                                <th>Display Home</th>
                                <th>Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ @$value->title }}</td>
                                    <td>
                                        <img src="{{ @$value->image }}" alt="{{ @$value->title }}"
                                            class="img img-thumbail" style="width:60px">
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $value->slider_type }}
                                        </span>
                                    </td>

                                    <td>
                                        @if(@$value->position==null)
                                        <span class="badge badge-warning">0</span>
                                        @else
                                        <span class="badge badge-warning">{{@$value->position}}</span>

                                        @endif
                                    </td>

                                    <td>
                                        <label class="toggel_switch">
                                            <input class="display_home" data-id="{{@$value->id}}" type="checkbox" @if($value->display_home == '1') checked @endif >
                                            <span class="slider round"></span>
                                          </label>

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
                                            @can('slider-edit')
                                                <a href="{{ route('slider.edit', $value->id) }}" title="Edit Slider"
                                                    class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('slider-delete')
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['slider.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this Slider?")']) }}
                                                {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete Slider ']) }}
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
          var slider_id = $(this).data('id');
          var data = {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        slider_id: slider_id,
                    };
          $.ajax({
              type: "POST",
              url: "{{route('slider.changeStatus')}}",
              data: data,
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
      $('.display_home').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
          var data = {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id,
                    };
                    // console.log(data);
          $.ajax({
              type: "POST",
              url: "{{route('slider.changedisplayhome')}}",
              data: data,
              success: function(data){
                // console.log(data.success)
              }
          });

    })
  </script>
@endpush
