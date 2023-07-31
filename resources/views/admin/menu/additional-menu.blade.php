@extends('layouts.admin')
@section('title', @$title)
    @push('scripts')
    @include('admin.section.ckeditor')
   
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $('#featured_img_button').filemanager('image');
            $('#parallex_img_button').filemanager('image');

            $(document).ready(function() {
                $('#category').select2({
                    placeholder: "News Category",
                });
            });

        </script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/menu.js') }}">
        </script>
        <script>
            $(document).ready(function() {
                // $('#featured_img').change(function() {
                //     var input = this;
                //     if (input.files && input.files[0]) {
                //         let reader = new FileReader();
                //         reader.onload = function(e) {
                //             $('#featured_image_view').attr('src', e.target.result).fadeIn(1000);
                //             $('#featured_image_view').removeClass('d-none');
                //         }
                //         reader.readAsDataURL(input.files[0]);
                //     }
                // })

                // $('#parallex_img').change(function() {
                //     var input = this;
                //     if (input.files && input.files[0]) {
                //         let reader = new FileReader();
                //         reader.onload = function(e) {
                //             $('#parallex_image_view').attr('src', e.target.result).fadeIn(1000);
                //             $('#parallex_image_view').removeClass('d-none');
                //         }
                //         reader.readAsDataURL(input.files[0]);
                //     }
                // })
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
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('menu.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::open(['url' => route('menu.update', $data->id), 'files' => true, 'class' => 'form', 'name' => 'menu_form']) }}
                    @method('put')
                    <div class="row">
                        <div class="col-lg-9">
                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('np_title') ? 'has-error' : '' }}">
                                    {{ Form::label('np_title', 'Menu Title:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('np_title', @$data->title['np'], ['class' => 'form-control', 'id' => 'np_title', 'placeholder' => 'Enter Menu Title', 'required' => true, 'style' => 'width:80%', 'readonly']) }}
                                        @error('np_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                    {{ Form::label('en_title', 'Menu Title:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('en_title', @$data->title['en'], ['class' => 'form-control', 'id' => 'en_title', 'placeholder' => 'Enter Menu Title', 'required' => true, 'style' => 'width:80%', 'readonly']) }}
                                        @error('en_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                            <div class="form-group row {{ $errors->has('content_type') ? 'has-error' : '' }}">
                                {{ Form::label('content_type', 'Content Type :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('content_type', @$data->content_type, ['id' => 'slug', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%', 'readonly']) }}
                                    @error('content_type')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('external_url') ? 'has-error' : '' }}">
                                {{ Form::label('external_url', 'Menu external link:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('external_url', @$data->external_url, ['class' => 'form-control form-control', 'id' => 'external_url', 'placeholder' => 'Enter Menu external link', 'style' => 'width:80%']) }}
                                    <small class="text-danger">Enter only if you need to redirect it to external
                                        link</small>
                                    @error('external_url')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div
                                    class="form-group row {{ $errors->has('np_short_description') ? 'has-error' : '' }}">
                                    <div class="col-md-12">
                                        {{ Form::label('np_short_description', 'Short Description (in Nepali) :*') }}
                                        {{ Form::textarea('np_short_description', @$data->short_description['np'], ['class' => 'form-control   col-lg-6', 'rows' => 3, 'id' => 'np_short_description', 'placeholder' => 'Content Short Description (in Nepali)', 'required' => true, 'style' => 'height:40%']) }}
                                        @error('np_short_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                                <div
                                    class="form-group row {{ $errors->has('en_short_description') ? 'has-error' : '' }}">
                                    <div class="col-md-12">
                                        {{ Form::label('en_short_description', 'Short Description (in English) :*') }}
                                        {{ Form::textarea('en_short_description', @$data->short_description['en'], ['class' => 'form-control   col-lg-6', 'rows' => 3, 'id' => 'en_short_description', 'placeholder' => 'Content Short Description (in English)', 'required' => true, 'style' => 'height:40%']) }}
                                        @error('en_short_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('np_description') ? 'has-error' : '' }}">
                                    <div class="col-md-12">
                                        {{ Form::label('np_description', 'Full Description  (in Nepali):*') }}
                                        {{ Form::textarea('np_description', @$data->description['np'], ['class' => 'form-control  ', 'id' => 'np_description', 'placeholder' => 'Content Description', 'required' => true]) }}
                                        @error('np_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                    <div class="col-md-12">
                                        {{ Form::label('en_description', 'Full Description  (in English):*') }}
                                        {{ Form::textarea('en_description', @$data->description['np'], ['class' => 'form-control  ', 'id' => 'en_description', 'placeholder' => 'Content Description', 'required' => true]) }}
                                        @error('en_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_title', 'Meta Title :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_title', @$data->meta_title, ['class' => 'form-control', 'id' => 'meta_title', 'rows' => '3', 'placeholder' => 'Meta Title', 'style' => 'width:80%']) }}
                                            @error('meta_title')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_keyword', 'Meta Keyword :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_keyword', @$data->meta_keyword, ['class' => 'form-control', 'id' => 'meta_keyword', 'placeholder' => 'Meta Keyword', 'rows' => 3, 'style' => 'width:80%']) }}
                                            @error('meta_keyword')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row {{ $errors->has('meta_keyphrase') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_keyphrase', 'Meta Keyphase :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_keyphrase', @$data->meta_keyphrase, ['class' => 'form-control', 'id' => 'meta_keyphrase', 'placeholder' => 'Meta Keyphase', 'rows' => 3, 'style' => 'width:80%']) }}
                                            @error('meta_keyphrase')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div
                                        class="form-group row {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                        {{ Form::label('meta_description', 'Meta Description :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('meta_description', @$data->meta_description, ['class' => 'form-control', 'id' => 'meta_description', 'rows' => 3, 'placeholder' => 'Meta Description', 'style' => 'width:80%']) }}
                                            @error('meta_description')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group row {{ $errors->has('featured_img') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="featured_img_button" data-input="featured_img" data-preview="holder"
                                            class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="featured_img" class="form-control" type="text" name="featured_img"
                                        value="{{ @$data->featured_img_url }}">
                                </div>
                                @error('featured_img')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                                <div id="holder" style="margin-top:15px;max-width: 100%;">
                                    <img src="{{ @$data->featured_img_thumb_url }}" alt="" style="max-width: 100%">
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('parallex_img') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="parallex_img_button" data-input="parallex_img" data-preview="parallex_img_holder"
                                            class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="parallex_img" class="form-control" type="text" name="parallex_img"
                                        value="{{ @$data->parallex_img_url }}">
                                </div>
                                @error('parallex_img')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                                <div id="parallex_img_holder" style="margin-top:15px;max-width: 100%;">
                                    <img src="{{ @$data->parallex_img_thumb_url }}" alt="" style="max-width: 100%">
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Menu Publish Status:*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('publish_status', ['0' => 'In-Active', '1' => 'Active'], @$data->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
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
                        </div>
                    </div>
                    {{ Form::close() }}





                </div>
            </div>
    </section>
@endsection
