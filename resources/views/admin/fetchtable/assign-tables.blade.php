@extends('layouts.admin')
@section('title', 'Database Table List ')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2_option').select2({
                    placeholder: "Select Table",
                    allowClear: true
                });
            });
           

        </script>
    @endpush
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
                            {{-- <form action="" class="">
                                <div class="row">
                                    <div class="  col-lg-6 col-md-6 col-sm-6">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control form-control-sm', 'placeholder' => 'Search title']) !!}
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat btn-sm">
                                            <i class="fa fa fa-search"></i>
                                            Filter
                                        </button>
                                        <a href="{{ route('adminGetTables') }}"
                                            class="btn btn-primary btn-flat btn-sm">Assign Tables</a>
                                    </div>
                                </div>
                            </form> --}}

                        </div>
                    </div>
                </div>
                {!! Form::open(['method' => 'post']) !!}
                <div class="row">
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-12  ">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>External Table Name </th>
                                    <th>Internal Table Name </th>
                                    <th>Assigned Table </th>
                                    <th>Content Type </th>
                                    <th>Web Framework </th>
                                    <th>Model </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($database2 as $external_database_key => $external_table_data)
                               
                                    <tr>
                                        {{-- dd($old_data) --}}
 
                                        <td>{{ $external_table_data->$dbname2 }} / {{ @$old_data[$external_database_key]->internal_table }}</td>
                                        <td>

                                            <select name="tables[{{ $external_table_data->$dbname2 }}]"
                                                class="form-control form-control-sm select2_option">
                                                <option value="">Select Table</option>
                                                @if (isset($database1) && $database1->count())
                                                    @foreach ($database1 as $key => $database_table)
                                                        <option value="{{ $database_table->$db }}"
                                                            {{ $database_table->$db == @$old_data[$external_database_key]->internal_table ? 'selected' : '' }}>
                                                            {{ $database_table->$db }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            {{ @$old_data[$external_database_key]->internal_table }}
                                        </td>

                                        <td>
                                            {{ Form::select("content_type[".$external_table_data->$dbname2."]", CONTENT_LIST, @$old_data[$external_database_key]->content_type  , ['class' => 'form-control form-control-sm ', 'id' => 'direction',  'style' => 'width:80%', 'placeholder' => 'Content']) }}
                                        </td>
                                        <td>
                                            {{-- @$old_data[$key] --}}
                                            {{ Form::select("framework[".$external_table_data->$dbname2."]", $frameworkType, @$old_data[$external_database_key]->framework, ['class' => 'form-control form-control-sm ', 'id' => 'direction',  'style' => 'width:80%', 'placeholder' => 'Website Framwork']) }}

                                        </td>
                                        <td>
                                            {{-- @$old_data[$external_database_key]->model_name --}}
                                            <select name="model_name[{{ $external_table_data->$dbname2 }}]" id="model_name[]" class="form-control" style="width:80%">
                                                @if (isset($models))
                                                    @foreach ($models as $key => $model)
                                                        <option value="{{ $model->classname }}"
                                                            {{ @$old_data[$external_database_key]->model_name == $model->classname ? 'selected' : '' }}>
                                                            {{ $model->classname }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                
                                                @if (@$old_data[$external_database_key]->external_table)
                                                    <a href="{{ route('migrateTableContent', $external_table_data->$dbname2) }}"
                                                        title="view columns of the table"
                                                        class="btn btn-success btn-sm btn-flat ">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="col-sm-12">
                        {{ Form::button("<i class='fa fa-swap-plane'></i> Update", ['class' => 'btn btn-success migrateButton btn-flat', 'type' => 'submit']) }}
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
