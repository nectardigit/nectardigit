@extends('layouts.admin')
@section('title', 'Database Table List ')
    @push('scripts')
        <script>
            // $(document).on('submit', 'form', function(e) {
            //     $('.migrateButton').html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`);
            //     e.preventDefault();
            //     $.ajax({
            //         method: 'POST',
            //         dataType: 'JSON',
            //         contentType: false,
            //         cache: false,
            //         processData: false,
            //         url: "{{ route('startMigratingContent') }}",
            //         data: new FormData(this),
            //         success: function(response) {
            //             if (response.success) {
            //                 console.log("response is on sucess", response);
            //             } else {
            //                 alert(response.message);
            //             }
            //         }
            //     })
            // })

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
                                <i class="fas fa-plus fa-sm"></i> Start Migrating 
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::open(['method' => 'post', 'url' => $route]) !!}
                @csrf
                <div class="row">
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Column</th>
                                    <th style="width: 250px">Content</th>

                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if ($content)
                                    @if ($content && $content[0])
                                        {!! Form::hidden('content_type', $old_db->content_type, []) !!}
                                        {!! Form::hidden('content_id', $old_db->id, []) !!}
                                        @foreach ($content[0] as $key => $value)
                                            <tr>
                                                <td>
                                                    <span style=" ">{{ $key }}</span>
                                                </td>
                                                <td> 
                                                    <span style="word-break: break-all">
                                                        {{ checkData($value)  }}
                                                    </span> 
                                                </td>
                                                <td>
                                                    <select name="column[{{ $key }}]" class="form-control form-control-sm">
                                                        <option value="">Select Column</option>
                                                        @foreach($internal_columns as $key => $column)
                                                            <option value="{{ $column }}">{{ $column }}</option>
                                                        @endforeach
                                                    </select>
                                                  
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        {!! Form::button("<i class='fa fa-swap-plane'></i>Assign Columns",  ['type' => 'submit', 'class' => 'btn btn-success migrateButton btn-flat',]) !!}
                        {{-- {{ Form::button("<i class='fa fa-swap-plane'></i> Start Migrating", ['class' => 'btn btn-success migrateButton btn-flat', 'type' => 'submit']) }} --}}
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
