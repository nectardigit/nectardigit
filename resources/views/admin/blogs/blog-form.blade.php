@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        @include('admin.section.ckeditor')
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
                        <a href="{{ route('blog.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($blog_info))
                        {{ Form::open(['url' => route('blog.update', $blog_info->id), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('blog.store'), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 ">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title:*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::text('title', @$blog_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Blog Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('tags') ? 'has-error' : '' }}">
                                {{ Form::label('tags', 'Tags :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('tags[]', @$tags, @$selectedtags, ['id' => 'tags', 'required' => false, 'class' => 'form-control select2', 'multiple' => true, 'style' => 'width:80%']) }}
                                    @error('tags')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                                {{ Form::label('category', 'category :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('category[]', @$category, @$selectedcategory, ['id' => 'category', 'required' => false, 'class' => 'form-control select2', 'multiple' => true, 'style' => 'width:80%']) }}
                                    @error('category')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', ' Blog Description :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::textarea('description', @$blog_info->description, ['class' => 'form-control ckeditor', 'id' => 'description', 'placeholder' => 'Blog Description in English', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <h3><strong>SEO Tools</strong></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_title', 'Meta Title :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_title', @$blog_info->meta_title, ['class' => 'form-control  ', 'id' => 'meta_title', 'rows' => 3, 'placeholder' => 'Meta Title', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                            @error('meta_title')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div
                                        class="form-group row {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_description', 'Meta Description :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_description', @$blog_info->meta_description, ['class' => 'form-control  ', 'id' => 'meta_description', 'rows' => 3, 'placeholder' => 'Meta Description', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                            @error('meta_description')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group row {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_keyword', 'Meta Keyword :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_keyword', @$blog_info->meta_keyword, ['class' => 'form-control  ', 'id' => 'meta_keyword', 'rows' => 3, 'placeholder' => 'Meta Keyword', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                            @error('meta_keyword')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group row {{ $errors->has('meta_keyphrase') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_keyphrase', 'Meta Keyphrase :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_keyphrase', @$blog_info->meta_keyphrase, ['class' => 'form-control  ', 'id' => 'meta_keyphrase', 'rows' => 3, 'placeholder' => 'Meta Keyphrase', 'required' => true, 'style' => 'width:80%; resize:none']) }}
                                            @error('meta_keyphrase')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12  ">

                            <div class="form-group row {{ $errors->has('featured_image') ? 'has-error' : '' }}">
                                {{ Form::label('featured_image', 'Featured Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="featured_image" data-preview="holder" class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="featured_image" height="100px" class="form-control" type="text" name="featured_image">
                                    </div>
                                    <div id="holder" style="border-radius: 4px;
                                                          padding: 5px;
                                                          width: 150px;
                                                          margin-top:15px;"></div>
                                    @if (isset($blog_info->featured_image))
                                        Old Image: &nbsp; <img src="{{ $blog_info->featured_image }}" alt="Couldn't load featured_image"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('featured_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('parallax_image') ? 'has-error' : '' }}">
                                {{ Form::label('parallax_image', 'Parallax Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm1" data-input="parallax_image" data-preview="holder_parallax" class="btn btn-primary">
                                                Choose
                                            </a>
                                        </span>
                                        <input id="parallax_image" height="100px" class="form-control" type="text" name="parallax_image">
                                    </div>
                                    <div id="holder_parallax" style="border-radius: 4px;
                                                          padding: 5px;
                                                          width: 150px;
                                                          margin-top:15px;"></div>
                                    @if (isset($blog_info->parallax_image))
                                        Old Image: &nbsp; <img src="{{ $blog_info->parallax_image }}" alt="Couldn't load parallax_image"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('parallax_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('display_home') ? 'has-error' : '' }}">
                                {{ Form::label('display_home', 'Display Home :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('display_home', [1 => 'Yes', 0 => 'No'], @$blog_info->display_home, ['id' => 'display_home', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('display_home')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$blog_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
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

                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
