@extends('layouts.admin')
@section('title', 'Add New Database')
    @push('scripts')
    @endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Database</h3>
                    <div class="card-tools">
                        <a href="{{ route('wordpressbackup.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-body">
                        {{ Form::open(['url' => route('wordpressbackup.store'), 'files' => true, 'class' => 'form', 'name' => 'user_form']) }}

                    <div class="form-group row {{ $errors->has('database') ? 'has-error' : '' }}">
                        {{ Form::label('database', 'Database:*', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::file('database', ['class' => 'form-control', 'id' => 'database', 'placeholder' => 'User database', 'required' => true, 'style' => 'width:80%', 'disabled' => isset($user_detail) ? true : false]) }}
                            @error('database')
                                <span class="help-block error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-flat', 'type' => 'submit']) }}
                            {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-danger btn-flat', 'type' => 'reset']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
