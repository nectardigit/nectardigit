@extends('layouts.admin')
@section('title', $pageTitle)
    @push('scripts')
        @include('admin.section.ckeditor')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <link rel="stylesheet" href="{{ asset('assets/datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">

        {{-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> --}}
        <script src="{{ asset('assets/datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script>
            $('#lfm').filemanager('image');
            $('#feature_img_lfm').filemanager('image');
            $(function() {
                $('#datepicker').datetimepicker();
            });

        </script>
        @livewireScripts
        <script>
            window.livewire.on('storeTag', () => {
                $('#modal-tag').modal('hide');
                // $('#tags').
                $('#tags').select2({
                    placeholder: "News Tags",
                });
            });
            $("#addTagModal").on('click', function() {
                $('#modal-tag').modal('show');
            })
            $(document).ready(function() {
                $('#tags').select2({
                    placeholder: "News Tags",
                });
            });
            $(document).ready(function() {
                $('#category').select2({
                    placeholder: "News Category",
                });
            });

        </script>
    @endpush
@section('content')
    @include('admin.shared.image_upload')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('news.index') }}" class="btn btn-success btn-sm btn-flat mr-2">
                            News list
                        </a>
                        <a href="{{ route('news.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>


                @include('admin.shared.error-messages')
                <div class="card-body">

                    @if (isset($newsInfo))
                        {{ Form::open(['url' => route('news.update', $newsInfo->id), 'files' => true, 'class' => 'form', 'name' => 'dataForm', 'autocomplete' => false]) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('news.store'), 'files' => true, 'class' => 'form', 'name' => 'dataForm', 'autocomplete' => false]) }}
                    @endif
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 ">

                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('np_title') ? 'has-error' : '' }}">
                                    {{ Form::label('np_title', 'News Title (NP) :*', ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('np_title', @$newsInfo->title['np'], ['class' => 'form-control', 'id' => 'np_title', 'placeholder' => 'News Title (in Nepali)', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('np_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                    {{ Form::label('en_title', 'News   Title (EN) :', ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('en_title', @$newsInfo->title['en'], ['class' => 'form-control', 'maxlength' => '25', 'id' => 'en_title', 'placeholder' => 'News   Title (in English)', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('en_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                                {{ Form::label('category', 'News Category :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">

                                    {{ Form::select('category[]', @$news_category, @$newsInfo->category, ['class' => 'form-control  ', 'id' => 'category', 'multiple' => true, 'required' => true, 'style' => 'width:80%']) }}
                                    @error('category')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Banner display style selection field --}}
                            <div class="form-group row {{ $errors->has('text_position') ? 'has-error' : '' }}">
                                {{ Form::label('text_position', 'Banner News Text Position :*', ['class' => 'col-sm-12']) }}

                                <div class="col-sm-12">

                                    {{ Form::select('text_position', @$banner_type, @$newsInfo->text_position, ['class' => 'form-control', 'id' => 'banner', 'multiple' => false, 'required' => true, 'style' => 'width:80%']) }}
                                    @error('text_position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('isBanner') ? 'has-error' : '' }}">
                                {{ Form::label('isBanner', 'banner:', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('isBanner', [ 0 => 'No',1 => 'Yes'], @$newsInfo->isBanner, ['id' => 'isBanner', 'required' => false, 'class' => 'form-control', 'style' => 'width:90%']) }}
                                    @error('isBanner')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('guest') ? 'has-error' : '' }}">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        {{ Form::label('guest', 'Guest Information :*', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::select('guest', @$guestlist, @$newsInfo->guestId, ['class' => 'form-control  ', 'id' => 'guest', 'style' => 'width:80%']) }}
                                            @error('guest')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        {{ Form::label('reporter', 'Reporter name :*', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">

                                            {{ Form::select('reporter', @$reporters, @$newsInfo->reporter, ['class' => 'form-control  ', 'id' => 'reporter', 'placeholder' => 'Reporter name *', 'required' => true, 'style' => 'width:80%']) }}
                                            @error('reporter')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- {{ dd($tags) }} --}}
                            <livewire:admin.taglist :newsdata="@$newsInfo">

                                @if ($_website == 'Nepali' || $_website == 'Both')
                                    <div class="form-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                                        {{ Form::label('category', 'News Category :*', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('np_description', @$newsInfo->description['np'], ['class' => 'form-control ckeditor', 'maxlength' => '100', 'id' => 'np_description', 'placeholder' => ' News  Description in Nepali', 'style' => 'width:80%']) }}
                                            @error('np_description')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                @endif
                                @if ($_website == 'English' || $_website == 'Both')
                                    <div class="form-group row {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                        {{ Form::label('en_description', ' News Description (EN) :*', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('en_description', @$newsInfo->description['en'], ['class' => 'form-control ckeditor', 'id' => 'en_description', 'placeholder' => 'News Description in English', 'required' => true, 'style' => 'width:80%']) }}
                                            @error('en_description')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                {{-- <div class="row">
                                    <div class="col-lg-12">
                                        <h3><strong>SEO Tools</strong></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                            {{ Form::label('meta_title', 'Meta Title :', ['class' => 'col-sm-12']) }}
                                            <div class="col-sm-12">
                                                {{ Form::textarea('meta_title', @$newsInfo->meta_title, ['class' => 'form-control  ', 'id' => 'meta_title', 'rows' => 3, 'placeholder' => 'Meta Title', 'style' => 'width:80%; resize:none']) }}
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
                                                {{ Form::textarea('meta_description', @$newsInfo->meta_description, ['class' => 'form-control  ', 'id' => 'meta_description', 'rows' => 3, 'placeholder' => 'Meta Description', 'style' => 'width:80%; resize:none']) }}
                                                @error('meta_description')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div
                                            class="form-group row {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                                            {{ Form::label('meta_keyword', 'Meta Keyword :', ['class' => 'col-sm-12']) }}
                                            <div class="col-sm-12">
                                                {{ Form::textarea('meta_keyword', @$newsInfo->meta_keyword, ['class' => 'form-control  ', 'id' => 'meta_keyword', 'rows' => 3, 'placeholder' => 'Meta Keyword', 'style' => 'width:80%; resize:none']) }}
                                                @error('meta_keyword')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div
                                            class="form-group row {{ $errors->has('meta_keyphrase') ? 'has-error' : '' }}">
                                            {{ Form::label('meta_keyphrase', 'Meta Keyphrase :', ['class' => 'col-sm-12']) }}
                                            <div class="col-sm-12">
                                                {{ Form::textarea('meta_keyphrase', @$newsInfo->meta_keyphrase, ['class' => 'form-control  ', 'id' => 'meta_keyphrase', 'rows' => 3, 'placeholder' => 'Meta Keyphrase', 'style' => 'width:80%; resize:none']) }}
                                                @error('meta_keyphrase')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        </div> --}}


                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            {{ Form::label('news_image', 'News Image :', ['class' => 'col-sm-8', 'style' => 'padding-left: 0px']) }}
                            <div class="form-group row">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="filepath"
                                        value="{{ @$newsInfo->image_url }}">
                                </div>
                                <div id="holder" style="margin-top:15px;max-width: 100%;">
                                    <img src="{{ @$newsInfo->image_thumb_url }}" alt="" style="max-width: 100%">
                                </div>
                            </div>


                            <div class="form-group row">
                                {{ Form::label('feature_image', 'Feature Image :', ['class' => 'col-sm-12', 'style' => 'padding-left: 0px']) }}
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="feature_img_lfm" data-input="feature_img" data-preview="feature_img_holder"
                                            class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="feature_img" class="form-control" type="text" name="feature_img">
                                </div>
                                <!-- <div id="feature_img_holder" style="margin-top:15px;max-width: 100%;">
                                                                                    <img src="{{ @$newsInfo->image_thumb_url }}" alt="" style="max-width: 100%">
                                                                                </div> -->
                            </div>
                            <div class="form-group row {{ $errors->has('published_at') ? 'has-error' : '' }}">
                                {{ Form::label('published_at', 'Publish Date :', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">

                                    {{ Form::text('published_at', @$published_at, ['id' => 'datepicker', 'required' => false, 'class' => 'form-control date']) }}

                                    @error('published_at')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @canany(['newsenglish-publish','newsnepali-publish'])
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$newsInfo->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:90%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endcanany
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
        </div>
    </section>
@endsection
