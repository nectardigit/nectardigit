@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        @include('admin.section.ckeditor')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $(document).ready(function() {
                $('#lfm').change(function() {
                    $('#thumbnail').removeClass('d-none');
                })
                $('#roles').select2({
                    placeholder: "User Role",
                });
            });
            $('#lfm').filemanager('image');

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
                        <a href="{{ route('video.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($video_info))
                        {{ Form::open(['url' => route('video.update', $video_info->id), 'class' => 'form', 'name' => 'video_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('video.store'), 'class' => 'form', 'name' => 'video_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-9">
                            {{-- {{ dd($video_info->title['en']) }} --}}
                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                    {{ Form::label('en_title', 'English Full Name (EN):*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('en_title', @$video_info->title['en'], ['class' => 'form-control', 'id' => 'en_title', 'placeholder' => 'English title', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('en_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('np_title') ? 'has-error' : '' }}">
                                    {{ Form::label('np_title', 'Nepali title (NP):*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('np_title', @$video_info->title['np'], ['class' => 'form-control', 'id' => 'np_title', 'placeholder' => 'Nepali title', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('np_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row {{ $errors->has('url') ? 'has-error' : '' }}">
                                {{ Form::label('url', 'url video :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::url('url', @$video_info->url, ['class' => 'form-control', 'id' => 'url', 'placeholder' => 'url', 'style' => 'width:80%']) }}
                                    @error('url')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                    {{ Form::label('en_description', 'Description(EN) :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-8">
                                        {{ Form::textarea('en_description', @$video_info->description['en'], ['class' => 'form-control ckeditor', 'id' => 'my-editor1', 'placeholder' => 'Feature Long Description', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('en_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('np_description') ? 'has-error' : '' }}">
                                    {{ Form::label('np_description', 'Description(NP) :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-8">
                                        {{ Form::textarea('np_description', @$video_info->description['np'], ['class' => 'form-control ckeditor', 'id' => 'my-editor2', 'placeholder' => 'Feature Long Description', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('np_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="form-group row">
                                <div class="input-group">
                                    {{ Form::label('image', 'Featured Image:*', ['class' => 'col-sm-3']) }}
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="hidden" name="image"
                                        value="{{ @$video_info->image }}">
                                </div>

                                <div class="col-lg-4"></div>

                                <div id="holder" style="border-radius: 4px;
                                padding: 5px;
                                width: 150px;
                                margin-top:15px;"></div>
                                    @if(isset($video_info))
                                    <img src="{{ create_image_url(@$video_info->image, 'banner') }}" alt=""
                                        style="max-width: 100%">
                                    @endif


                            </div> --}}

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Featured Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="image" data-preview="holder" class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="image" height="100px" class="form-control" type="text" name="image" value="{{@$video_info->image}}">
                                    </div>
                                    <div id="holder" style="border-radius: 4px;
                                                          padding: 5px;
                                                          width: 150px;
                                                          margin-top:15px;"></div>
                                    @if (isset($video_info->image))
                                        Old Image: &nbsp; <img src="{{ $video_info->image }}" alt="Couldn't load image"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('display_home') ? 'has-error' : '' }}">
                                {{ Form::label('display_home', 'Display Home :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-8">
                                    {{ Form::select('display_home', [0 => 'No', 1 => 'Yes'], @$video_info->display_home, ['id' => 'display_home', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('display_home')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                                {{ Form::label('position', 'position :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-8">
                                    {{ Form::number('position', @$video_info->position, ['id' => 'position', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-8">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$video_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-8">
                                    {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-sm btn-success btn-flat', 'type' => 'submit']) }}
                                    {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-sm btn-danger btn-flat', 'type' => 'reset']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">

                        </div>
                    </div>
                    {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}

                </div>

                {{ Form::close() }}
            </div>
        </div>
        </div>
    </section>
@endsection
