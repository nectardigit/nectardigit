@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/feature.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#icon').change(function() {
                    $('#icon_view').removeClass('d-none');
                })
                $('#feature_image').change(function() {
                    $('#feature_image_view').removeClass('d-none');
                })
                $('#parallax_image').change(function() {
                    $('#parallax_image_view').removeClass('d-none');
                })
            })

        </script>
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
                        <a href="{{ route('feature.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($feature_info))
                        {{ Form::open(['url' => route('feature.update', $feature_info->id), 'files' => true, 'class' => 'form', 'name' => 'feature_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('feature.store'), 'files' => true, 'class' => 'form', 'name' => 'feature_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Feature Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$feature_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Feature Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('short_title') ? 'has-error' : '' }}">
                                {{ Form::label('short_title', 'Feature Short Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('short_title', @$feature_info->short_title, ['class' => 'form-control', 'maxlength' => '25', 'id' => 'short_title', 'placeholder' => 'Feature Short Title', 'style' => 'width:80%']) }}
                                    @error('short_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('short_description') ? 'has-error' : '' }}">
                                {{ Form::label('short_description', 'Feature Short Description :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('short_description', @$feature_info->short_description, ['class' => 'form-control ckeditor', 'maxlength' => '100', 'id' => 'my-editor', 'placeholder' => 'Feature Short Description', 'style' => 'width:80%']) }}
                                    @error('short_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('full_description') ? 'has-error' : '' }}">
                                {{ Form::label('full_description', 'Feature Long Description :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('full_description', @$feature_info->full_description, ['class' => 'form-control ckeditor', 'id' => 'my-editor1', 'placeholder' => 'Feature Long Description', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('full_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                                {{ Form::label('position', 'Feature Position :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('position', @$feature_info->position, ['class' => 'form-control', 'id' => 'position', 'placeholder' => 'Feature Position', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$feature_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('icon') ? 'has-error' : '' }}">
                                {{ Form::label('icon', 'Icon:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::file('icon', ['id' => 'icon', 'class' => 'cropImage', 'name' => 'icon', 'style' => 'width:80%', 'accept' => 'image/*', 'onchange' => 'uploadImage(this);']) }}
                                    <input type="hidden" name="icon_name" id="icon_name"
                                        value="{{ @$feature_info->icon }}">
                                    @error('icon')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror

                                    <div class="col-sm-4">
                                        <img id="icon_view"
                                            src="{{ getImageUrl(@$feature_info->icon, featureimagepath) }}" alt="icon"
                                            class="d-none img-fluid img-thumbnail" style="height: 80px" />
                                        @if (isset($feature_info->icon))
                                            @if (file_exists(public_path() . '/uploads' . featureimagepath . '/' . @$feature_info->icon))
                                                <img src="{{ asset('/uploads' . featureimagepath . '/' . @$feature_info->icon) }}"
                                                    alt="{{ @$feature_info->icon }}" class="img img-fluid img-thumbnail"
                                                    style="height:80px" id=" ">
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('feature_image') ? 'has-error' : '' }}">
                                {{ Form::label('feature_image', 'Feature Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::file('feature_image', ['id' => 'feature_image', 'class' => 'cropImage', 'name' => 'feature_image', 'style' => 'width:80%', 'accept' => 'image/*', 'onchange' => 'uploadImage(this);']) }}
                                    <input type="hidden" name="feature_image_name" id="feature_image_name"
                                        value="{{ @$feature_info->feature_image }}">
                                    @error('feature_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror

                                    <div class="col-sm-4">
                                        <img id="feature_image_view"
                                            src="{{ getImageUrl(@$feature_info->feature_image, featureimagepath) }}"
                                            alt="feature_image" class="d-none img-fluid img-thumbnail"
                                            style="height: 80px" />
                                        @if (isset($feature_info->feature_image))
                                            @if (file_exists(public_path() . '/uploads' . featureimagepath . '/' . @$feature_info->feature_image))
                                                <img src="{{ asset('/uploads' . featureimagepath . '/' . @$feature_info->feature_image) }}"
                                                    alt="{{ @$feature_info->feature_image }}"
                                                    class="img img-fluid img-thumbnail" style="height:80px" id=" ">
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('parallax_image') ? 'has-error' : '' }}">
                                {{ Form::label('parallax_image', 'Parallax Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::file('parallax_image', ['id' => 'parallax_image', 'class' => 'cropImage', 'name' => 'parallax_image', 'style' => 'width:80%', 'accept' => 'image/*', 'onchange' => 'uploadImage(this);']) }}
                                    <input type="hidden" name="parallax_image_name" id="parallax_image_name"
                                        value="{{ @$feature_info->parallax_image }}">
                                    @error('parallax_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror

                                    <div class="col-sm-4">
                                        <img id="parallax_image_view"
                                            src="{{ getImageUrl(@$feature_info->parallax_image, featureimagepath) }}"
                                            alt="parallax_image" class="d-none img-fluid img-thumbnail"
                                            style="height: 80px" />
                                        @if (isset($feature_info->parallax_image))
                                            @if (file_exists(public_path() . '/uploads' . featureimagepath . '/' . @$feature_info->parallax_image))
                                                <img src="{{ asset('/uploads' . featureimagepath . '/' . @$feature_info->parallax_image) }}"
                                                    alt="{{ @$feature_info->parallax_image }}"
                                                    class="img img-fluid img-thumbnail" style="height:80px" id=" ">
                                            @endif
                                        @endif
                                    </div>
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
