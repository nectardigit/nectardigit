@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        @include('admin.section.ckeditor')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/blog.js') }}"></script>
        <script>
            $('#lfm').filemanager('image');
            $(document).ready(function() {
                $(".select2").select2();
            })
        </script>
        @include('admin.section.ckeditor')

    @endpush
@section('content')

    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }} List</h3>
                    <div class="card-tools">
                        <a href="{{ route('notice.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($notice_info))
                        {{ Form::open(['url' => route('notice.update', $notice_info->id), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('notice.store'), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                    @endif


                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::text('title', @$notice_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', ' Blog Description :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('description', @$notice_info->description, ['class' => 'form-control ckeditor', 'id' => 'description', 'placeholder' => 'Description in English', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="image" data-preview="holder" class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="image" height="100px" class="form-control" type="text" name="image" >
                                    </div>
                                    <div id="holder" style="border-radius: 4px;
                                                          padding: 5px;
                                                          width: 150px;
                                                          margin-top:15px;"></div>
                                    @if (isset($notice_info->image))
                                        Old Image: &nbsp; <img src="{{ $notice_info->image }}" alt="Couldn't load image"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                                {{ Form::label('position', 'Position:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::number('position', @$notice_info->position, ['class' => 'form-control', 'id' => 'position', 'placeholder' => 'position', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$notice_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row">
                                {{ Form::label('', '', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
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
