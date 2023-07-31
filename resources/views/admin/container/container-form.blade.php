@extends('layouts.admin')
@section('title', $title)
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
    {{-- <script src="{{ asset('/custom/benefit.js') }}"></script> --}}
    <script>
        $('#lfm').filemanager('image');
        $(document).ready(function() {
            $('#type').select2({
                placeholder: "Select Container Type",
            });
            $('#publish_status').select2();
        })
    </script>
    @include('admin.section.ckeditor')
@endpush
@section('content')
    @include('admin.shared.image_upload')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('container.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                {{-- @include('admin.shared.error-messages') --}}
                <div class="card-body">
                    @if (isset($container_info))
                        {{ Form::open(['url' => route('container.update', $container_info->id), 'files' => true, 'class' => 'form', 'name' => 'container_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('container.store'), 'files' => true, 'class' => 'form', 'name' => 'container_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$container_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Enter Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Description :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$container_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'placeholder' => 'Enter Description', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('type') ? 'has-error' : '' }}">
                                {{ Form::label('type', 'Type :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('type', ['benefits' => 'Benefits', 'mission_vision' => 'Mission/Vision', 'customer_satisfy' => 'Customer Satisfaction'], @$container_info->type, ['id' => 'type', 'required' => true, 'class' => 'form-control', 'placeholder' => 'Choose Types of Container', 'style' => 'width:80%']) }}
                                    @error('type')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('icon') ? 'has-error' : '' }}">
                                {{ Form::label('icon', 'Font Awesome Icon:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('icon', @$container_info->icon, ['class' => 'form-control', 'id' => 'icon', 'placeholder' => 'fa fa-cloud-upload', 'style' => 'width:80%']) }}
                                    @error('icon')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                                {{ Form::label('position', 'Position :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('position', @$container_info->position, ['class' => 'form-control', 'id' => 'position', 'placeholder' => 'Position', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="image" data-preview="holder" class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="image" height="100px" class="form-control" type="text" name="image">
                                    </div>
                                    <div id="holder" style="border-radius: 4px;
                                        padding: 5px;
                                        width: 150px;
                                        margin-top:15px;"></div>
                                    @if (isset($container_info->image))
                                        Old Image: &nbsp; <img src="{{ $container_info->image }}" alt="Couldn't load image"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$container_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

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
