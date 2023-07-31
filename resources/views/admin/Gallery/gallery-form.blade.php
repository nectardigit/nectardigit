@extends('layouts.admin')
@section('title', $title)
    @push('scripts')

        {{-- @include('admin.section.ckeditor') --}}
        <link rel="stylesheet" href="{{ asset('css/gallrey-custom.css') }}">
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/blog.js') }}"></script>
        <script>
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
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
                        <a href="{{ route('gallery.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($gallery_info))
                        {{ Form::open(['url' => route('gallery.update', $gallery_info->id), 'files' => true, 'class' => 'form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('gallery.store'), 'files' => true, 'class' => 'form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$gallery_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Gallery Title', 'required' => true, 'style' => 'width:80%']) }}
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
                                            <a id="lfm" data-input="cover_image" data-preview="holder"
                                                class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="cover_image" height="100px" class="form-control" type="text"
                                            name="cover_image" value="{{ @$gallery_info->cover_image }}">
                                    </div>
                                    <div id="holder" style="border-radius: 4px;
                                                                              padding: 5px;
                                                                              width: 150px;
                                                                              margin-top:15px;"></div>
                                    @if (isset($gallery_info->cover_image))
                                        Old Image: &nbsp; <img src="{{ $gallery_info->cover_image }}"
                                            alt="Couldn't load cover_image" class="img img-thumbail mt-2"
                                            style="width: 100px">
                                    @endif
                                    @error('cover_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('gallery_images') ? 'has-error' : '' }}">
                                {{ Form::label('gallery_images', 'Gallery Images:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm1" data-input="gallery_images" data-preview="holder_parallax"
                                                class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="gallery_images" height="100px" class="form-control" type="text"
                                            name="gallery_images[]" @if (isset($gallery_info->gallery_images)) value="{{ implode(',', $gallery_info->gallery_images) }}" @endif>
                                    </div>
                                    <div id="holder_parallax" style="border-radius: 4px;
                                                                              padding: 5px;
                                                                              width: 150px;
                                                                              margin-top:15px;"></div>
                                    @if (isset($gallery_info->gallery_images))
                                        Old Image:
                                        <div class="row">

                                            @foreach ($gallery_info->gallery_images as $key => $image)
                                                <div class="col-lg-3 remove_image{{ $key }}"
                                                    style="margin-bottom: 20px;">
                                                    <div class="gallery_img" id="removeimage{{ $key }}">
                                                        <a class="removeimage" data-id="{{ $image }}"
                                                            onclick="image_data('{{ $key }}','{{ $image }}');">
                                                            <i class="fas fa-times-circle" class="removeimage"></i>
                                                        </a>
                                                        <img src="{{ $image }}" alt="Couldn't load gallery_images"
                                                            class="img img-thumbail mt-2" style="width: 100px">
                                                    </div>
                                                </div>


                                            @endforeach
                                        </div>

                                    @endif
                                    @error('gallery_images')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                {{ Form::label('meta_title', 'Meta Title :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('meta_title', @$gallery_info->meta_title, ['class' => 'form-control  ', 'id' => 'meta_title', 'rows' => 3, 'placeholder' => 'Meta Title', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                    @error('meta_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                {{ Form::label('meta_description', 'Meta Description :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('meta_description', @$gallery_info->meta_description, ['class' => 'form-control  ', 'id' => 'meta_description', 'rows' => 3, 'placeholder' => 'Meta Description', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                    @error('meta_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                                {{ Form::label('meta_keyword', 'Meta Keyword :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('meta_keyword', @$gallery_info->meta_keyword, ['class' => 'form-control  ', 'id' => 'meta_keyword', 'rows' => 3, 'placeholder' => 'Meta Keyword', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                    @error('meta_keyword')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('meta_keyphrase') ? 'has-error' : '' }}">
                                {{ Form::label('meta_keyphrase', 'Meta Keyphrase :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('meta_keyphrase', @$gallery_info->meta_keyphrase, ['class' => 'form-control  ', 'id' => 'meta_keyphrase', 'rows' => 3, 'placeholder' => 'Meta Keyphrase', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                    @error('meta_keyphrase')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                                {{ Form::label('position', 'Position:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('position', @$gallery_info->position, ['class' => 'form-control', 'id' => 'position', 'placeholder' => 'Gallery position', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$gallery_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
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

@push('scripts')
    <script>
        function image_data(image_id, image) {
            var id = "<?php echo $gallery_info->id; ?>";

            var image = image;
            var data = {
                _token: "{{ csrf_token() }}",
                image: image,
                id: id,
            };

            $(".remove_image" + image_id).addClass('d-none');

            $.ajax({
                type: "POST",
                url: "{{ route('gallery.removeimage') }}",
                data: data,
                success: function(data) {

                }
            });

        }

    </script>
@endpush
