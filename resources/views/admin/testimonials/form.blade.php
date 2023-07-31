@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/testimonial.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#image').change(function() {
                    $('#thumbnail').removeClass('d-none');
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
                        <a href="{{ route('testimonial.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($testimonial_info))
                        {{ Form::open(['url' => route('testimonial.update', $testimonial_info->id), 'files' => true, 'class' => 'form', 'name' => 'testimonial_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('testimonial.store'), 'files' => true, 'class' => 'form', 'name' => 'testimonial_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Testimonial Name :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$testimonial_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Testimonial Name', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('designation') ? 'has-error' : '' }}">
                                {{ Form::label('designation', 'Testimonial Designation :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('designation', @$testimonial_info->designation, ['class' => 'form-control', 'id' => 'designation', 'placeholder' => 'Testimonial Designation', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('designation')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Testimonial Description :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$testimonial_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'placeholder' => 'Testimonial Description', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                                {{ Form::label('position', 'Testimonial Position :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('position', @$testimonial_info->position, ['class' => 'form-control', 'id' => 'position', 'placeholder' => 'Testimonial External Url', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$testimonial_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::file('image', ['id' => 'image', 'class' => 'cropImage', 'name' => 'image', 'style' => 'width:80%', 'accept' => 'image/*', 'onchange' => 'uploadImage(this);']) }}
                                    <input type="hidden" name="image_name" id="image_name"
                                        value="{{ @$information_info->thumbnail }}">
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                    <div class="col-sm-4">
                                        <img id="thumbnail" name="thumbnail"
                                            src="{{ getImageUrl(@$information_info->thumbnail, testimonialimagepath) }}"
                                            alt="image" class="d-none img-fluid img-thumbnail" style="height: 80px" />
                                        @if (isset($information_info->image))
                                            @if (file_exists(public_path('/uploads' . testimonialimagepath . 'thumbnail__' . @$information_info->image)))
                                                <img src="{{ asset('/uploads' . testimonialimagepath . 'thumbnail__' . @$information_info->image) }}"
                                                    alt="{{ $information_info->image }}"
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
