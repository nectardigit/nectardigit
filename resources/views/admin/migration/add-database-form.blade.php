@extends('layouts.admin')
@section('title', 'Database Table List ')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Upload Database</h3>
                    <div class="card-tools">
                        <a href="{{ route('fetchtable.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            {!! Form::open(['method' => 'post', 'url' => $route, 'files' => true]) !!}
                            @if ($old_db)
                                @method('put')
                            @endif
                            @csrf
                            <div class="form-group row {{ $errors->has('url') ? 'has-error' : '' }}">
                                {{ Form::label('url', 'Website url :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::text('url', @$old_db->url, ['class' => 'form-control  ', 'id' => 'direction', 'required' => true, 'style' => 'width:80%', 'placeholder' => 'Upload url']) }}
                                    @error('url')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row {{ $errors->has('content_type') ? 'has-error' : '' }}">
                                {{ Form::label('content_type', 'Content:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('content_type', CONTENT_LIST, @$old_db->content_type, ['class' => 'form-control  ', 'id' => 'direction', 'required' => true, 'style' => 'width:80%', 'placeholder' => 'Content']) }}
                                    @error('content_type')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('aspected_table') ? 'has-error' : '' }}">
                                {{ Form::label('aspected_table', 'Aspected Database Table:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    <select name="aspected_table" id="aspected_table" class="form-control"
                                        style="width:80%">
                                        @if (isset($database) && $database->count())
                                            @foreach ($database as $key => $database_table)
                                                <option value="{{ $database_table->$db }}"
                                                    {{ @$old_db->aspected_table == $database_table->$db ? 'selected' : '' }}>
                                                    {{ $database_table->$db }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('aspected_table')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('api_url') ? 'has-error' : '' }}">
                                {{ Form::label('api_url', 'Website api url :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::text('api_url', @$old_db->api_url, ['class' => 'form-control  ', 'id' => 'direction', 'required' => true, 'style' => 'width:80%', 'placeholder' => 'Upload api url']) }}
                                    @error('api_url')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('framework') ? 'has-error' : '' }}">
                                {{ Form::label('framework', 'Website Framwork:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('framework',  $frameworkType, @$old_db->framework, ['class' => 'form-control  ', 'id' => 'direction', 'required' => true, 'style' => 'width:80%', 'placeholder' => 'Website Framwork']) }}
                                    @error('framework')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('model_name') ? 'has-error' : '' }}">
                                {{ Form::label('model_name', 'Model:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <select name="model_name" id="model_name" class="form-control" style="width:80%">
                                        @if (isset($models))
                                            @foreach ($models as $key => $model)
                                                <option value="{{ $model->classname }}"
                                                    {{ @$old_db->model_name == $model->classname ? 'selected' : '' }}>
                                                    {{ $model->classname }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('model_name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-flat', 'type' => 'submit']) }}

                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
