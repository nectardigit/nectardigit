@extends('layouts.admin')
@section('title', 'Database Image List ')
    @push('scripts')
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
                    url: "{{ route('startMigratingImages') }}",
                    data: new FormData(this),
                    success: function(response) {
                        if (response.success) {
                            console.log("response is on sucess", response);
                        } else {
                            alert(response.message);
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
                                <i class="fas fa-plus fa-sm"></i> Add Database
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::open(['method' => 'post']) !!}
                @csrf
                <div class="row">
                    <div style="overflow-x: scroll" class="card-body card-format p-1 col-lg-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Old Content Id</th>
                                    <th style="width: 250px">Image name / Id</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($images))
                                    {!! Form::hidden('content_type', $old_db->content_type, []) !!}
                                    {!! Form::hidden('content_id', $old_db->id, []) !!}
                                    @foreach ($images as $key => $value)

                                        <tr>
                                            <td>

                                                <span style=" ">{{ $key }}</span>
                                            </td>
                                            <td>
                                                <span style="word-break: break-all">
                                                    {{ checkData($value->oldId) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span>{{ $value->thumbnail }}</span>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                        {{ @$images->links() }}
                    </div>
                    @if($images->count())
                    <div class="col-sm-12">
                        {{ Form::button("<i class='fa fa-swap-plane'></i> Start Migrating Images", ['class' => 'btn btn-success migrateButton btn-flat', 'type' => 'submit']) }}
                    </div>
                    @endif 

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
