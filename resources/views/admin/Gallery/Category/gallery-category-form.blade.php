@extends('layouts.admin')
@section('title', $title)
    @push('scripts')

        {{-- @include('admin.section.ckeditor') --}}
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
    <script src="{{ asset('/custom/blog.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');
        $(document).ready(function() {
            $(".select2").select2();
        })
    </script>

    @endpush
@section('content')

    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('gallerycategory.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($gallerycategory_info))
                        {{ Form::open(['url' => route('gallerycategory.update', $gallerycategory_info->id), 'files' => true, 'class' => 'form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('gallerycategory.store'), 'files' => true, 'class' => 'form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$gallerycategory_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Tag Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('cover_image') ? 'has-error' : '' }}">
                                {{ Form::label('cover_image', 'Cover Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="cover_image" data-preview="holder" class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="cover_image" height="100px" class="form-control" type="text" name="cover_image" value="{{@$gallery_info->cover_image}}">
                                    </div>
                                    <div id="holder" style="border-radius: 4px;
                                                          padding: 5px;
                                                          width: 150px;
                                                          margin-top:15px;"></div>
                                    @if (isset($gallery_info->cover_image))
                                        Old Image: &nbsp; <img src="{{ $gallery_info->cover_image }}" alt="Couldn't load cover_image"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('cover_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$gallerycategory_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
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
