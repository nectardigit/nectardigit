@extends('layouts.admin')
@section('title', 'Database Table List ')
    @push('scripts')
        <script>
             
             $(document).ready(function() {
                $('.column_selector').select2({
                    placeholder: "Select Column",
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
                            <i class="fa fa-list"></i>
                        </a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">

                        <div class="p-1 offset-lg-8 col-lg-4">
                            {{-- <a href="{{ route('migration.create') }}" class="btn btn-primary btn-flat btn-sm">
                                <i class="fas fa-plus fa-sm"></i> Add Database
                            </a> --}}
                            @if (isset($old_columns) && count($old_columns))

                                <a href="{{ route('moveDatabaseTableContent', $assigned_table->external_table) }}"
                                    class="btn btn-sm btn-success btn-flat" onclick="return confirm('Are you sure want to migrate data from old database to new one. Migrating database riskful , if any problem occurs during migration of data  may cause lose of existing.')">
                                    <i class='fa fa-swap-plane'></i> 
                                    Start Migrating
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
                {!! Form::open(['method' => 'post', 'url' => route('migrateTableContent', $assigned_table->external_table)]) !!}
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <h4><span class="alert alert-danger alert-sm">Note: </span></h4>
                        <p class="btn btn-warning">Developer notification : Setting up column to migrate data is riskful. Check old and new database and their's column structure, nature,  datatype, data length before  setting up the column  so that we  can minimize the  lose of data.  <br> While setting up column  for old one to new one  please carefully check corrosponding data format.</p>
                        <p class="btn btn-warning">
                            All the action in this page are only for expert developer who really have better knowledge of  database. If you are not a developer or  don't  have better database knowledge, please do nothing  here ,otherwise you may lose you all the data.
                        </p>
                    </div>
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    {{-- <th style="width: 10px">#</th> --}}
                                    <th>Column</th>
                                    <th style="width: 250px">Content</th>
                                    <th>Is primary key</th>

                                    <th>Assigned Column</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($external_table))
                                    {{-- {{ dd($assigned_table) }} --}}
                                    {!! Form::hidden('content_type', $assigned_table->content_type, []) !!}
                                    {!! Form::hidden('content_id', @$assigned_table->id, []) !!}

                                    @foreach ($external_table as $external_key => $value)



                                        <tr>
                                            <td>

                                                <span style=" ">{{ $external_key }}</span>
                                            </td>
                                            <td>
                                                <span style="word-break: break-all">
                                                    {!! checkData($value) !!}
                                                </span>
                                            </td>
                                            <td>
                                                {!! Form::label('is_primary_key[' . $external_key . ']', 'Is this primary key of the table  ?', ['']) !!}
                                                {!! Form::checkbox('is_primary_key[' . $external_key . ']', '1', mapdatabaseItem(@$assinged_data, $external_key), ['class' => '', 'placeholder' => 'Is this primary key of the table  ?']) !!}
                                            </td>
                                            <td>
                                                {{-- {{ dd($internal_columns) }} --}}
                                                {{-- dd($old_columns) --}}

                                                <select name="column[{{ $external_key }}]"
                                                    class="form-control form-control-sm btn btn-sm column_selector  {{ @$old_columns[$external_key] ? 'btn-success' : 'btn-primary' }}">
                                                    <option value="">Select Column</option>
                                                    @foreach ($internal_columns as $internal_key => $column)
                                                        <option value="{{ $column }}"
                                                            {{ $column == @$old_columns[$external_key] ? 'selected' : '' }}>
                                                            {{ $column }}</option>
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td>
                                                {{ @$old_columns[$external_key] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">

                        {{ Form::button("<i class='fa fa-swap-plane'></i> Assign Column", ['class' => 'btn btn-info   btn-flat btn-sm', 'type' => 'submit']) }}
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
