@extends('layouts.admin')
@section('title', 'Database Table List ')
    @push('scripts')
        <script src="{{ asset('plugins/sortablejs/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('plugins/toastrjs/toastr.min.js') }}"></script>
        <script>
            $(document).on('submit', 'form', function(e) {
                $('.migrateButton').html(
                    `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                );
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: "{{ route('startMigratingContent') }}",
                    data: new FormData(this),
                    success: function(response) {
                        toastr.options.closeButton = true;
                        if (response.status) {
                            toastr.success(response.message, "Success !");
                            console.log("response is on sucess", response);
                        } else {
                            toastr.error(response.message, "Error !");

                            // alert(response.message);
                        }
                    }
                })
            })

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

                        <div class="p-1 col-lg-7">
                            <a href="{{ route('migration.create') }}" class="btn btn-primary btn-flat btn-sm">
                                <i class="fas fa-reload fa-sm"></i> Re-structure swap columns
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::open(['method' => 'post', 'url' => route('migrateTableContent', $assigned_table->external_table)]) !!}
                @csrf
                <div class="row">
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Column</th>
                                    <th style="width: 250px">Content</th>

                                    <th>Assigned Column</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($external_table))
                                    {{-- {{ dd($assigned_table) }} --}}
                                    {!! Form::hidden('content_type', $assigned_table->content_type, []) !!}
                                    {!! Form::hidden('content_id', @$assigned_table->id, []) !!}
                                    {!! Form::hidden('type', 'internal') !!}
                                    @foreach ($external_table as $external_key => $value)

                                        <tr>
                                            <td></td>
                                            <td>

                                                <span style=" ">{{ $external_key }}</span>
                                            </td>
                                            <td>
                                                <span style="word-break: break-all">
                                                    {!! checkData($value) !!}
                                                </span>
                                            </td>
                                            {{-- <td>
                                              
                                                <select name="column[{{ $external_key }}]"
                                                    class="form-control form-control-sm btn btn-sm  {{ @$old_columns[$external_key] ? 'btn-success' : 'btn-primary' }}">
                                                    <option value="">Select Column</option>
                                                    @foreach ($internal_columns as $internal_key => $column)
                                                        <option  value="{{ $column }}" {{   $column == @$old_columns[$external_key] ? "selected" : '' }}>{{ $column }}</option>
                                                    @endforeach
                                                </select>

                                            </td> --}}
                                            <td>
                                                <span
                                                    class="btn btn-sm {{ @$old_columns[$external_key] ? 'btn-success' : '' }}">{{ @$old_columns[$external_key] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">

                        {{ Form::button("<i class='fa fa-swap-plane'></i> Start Migrating", ['class' => 'btn btn-success migrateButton btn-sm btn-flat', 'type' => 'submit']) }}
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
