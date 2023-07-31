@extends('layouts.admin')
@section('title', $pageTitle)
    @push('styles')
        <style>
            .check-list label {
                padding: 0;
            }

            .radio .ui-radio {
                margin: 20px;
            }

            .sidebar-dash {
                background: #f0eeee;
                padding: 15px;
                border-radius: 4px;
                border: 1px solid lightgrey;
                border-top: 2px solid rgb(20, 202, 235)
            }

            .btn-default.active,
            .btn-default.active:hover {
                background-color: #17a2b8;
                border-color: #138192;
                color: #fff;
            }

        </style>
    @endpush
    @push('scripts')
        @include('admin.section.ckeditor')
        <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
        <script src="{{ asset('/plugins/toastrjs/toastr.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('/assets/datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">

        {{-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> --}}
        <script src="{{ asset('/assets/datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script>
            $(function() {
                $('#datepicker').datetimepicker();
            });
            $('#MainImage').filemanager('image');
            $('#feature_img_lfm').filemanager('image');

            $(document).ready(function() {


                $('input[name="isVideo"]').click(function() {
                    if ($(this).attr('id') == 'videoactive') {
                        $('.isVideo').show();
                    } else {
                        $('.isVideo').hide();
                    }
                });
                if ($('input[name="isVideo"]#videoactive').is(':checked')) {

                    $('.isVideo').show();
                } else {

                    $('.isVideo').hide();
                }
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
                $('#reporter').select2({
                    placeholder: "News Reporter",
                });
                $("#guest").select2({
                    placeholder: "Guest Name "
                });
            });
            $(document).ready(function() {
                $('input[name="isBreaking"]').click(function() {
                    if ($(this).attr('id') == 'breaking') {
                        $('.breaking_text_position').show();
                    } else {
                        $('.breaking_text_position').hide();
                    }
                });
                if ($('input[name="isBreaking"]#breaking').is(':checked')) {

                    $('.breaking_text_position').show();
                } else {

                    $('.breaking_text_position').hide();
                }
            });

        </script>
        <script>
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            $(document).on('submit', 'form#guest-form', function(e) {
                e.preventDefault();
                var data = new FormData(this);
                data.append('_token', "{{ @csrf_token() }}");
                $.ajax({
                    url: "{{ route('addGuest') }}",
                    method: "post",
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: data,
                    success: function(response) {
                        if (response.status) {
                            $('#guest').html(response.html);
                            $('#exampleModalGuest').modal('hide');
                            toastr.options.closeButton = true
                            toastr.success(response.message, "Success !");
                        } else {
                            if (typeof response.message == "string") {
                                toastr.error(response.message, "Error !");
                            } else {
                                response.message.forEach(element => {
                                    toastr.error(element, "Error !");
                                });
                            }
                        }
                    },
                    error: function(response) {
                        // alert(response.message);
                        toastr.options.closeButton = true;
                        toastr.error(response.message, "Error !");
                        console.log('data_type ', typeof response.message);

                    }

                })
            })
            // $("#modal-submit-guest").click(function(e) {
            //     e.preventDefault();
            //     String.prototype.capitalize = function() {
            //         return this.charAt(0).toUpperCase() + this.slice(1);
            //     }
            //     e.preventDefault();
            //     data = {
            //         np_name: $('input[name=np_name]', '#guest-form').val(),
            //         phone: $('input[name=phone]', '#guest-form').val(),
            //         address: $('input[name=address]', '#guest-form').val(),
            //         email: $('input[name=email]', '#guest-form').val(),
            //         publish_status: "1"
            //     }
            //     axios.post("{{ route('guests.store', ['ajax' => 'true']) }}", data).then(res => {
            //         $('#exampleModalGuest').modal('toggle');
            //         var option = new Option(res.data.title.capitalize(), res.data.id, true, true);
            //         $('#guest').append(option).trigger('change');
            //         $('#guest').trigger({
            //             params: {
            //                 data: res.data
            //             }
            //         });
            //     }).catch(function(error) {
            //         console.log(error);
            //         $('#val-error-guest').css('display', 'block');
            //     });
            // });

        </script>
        <script>
            $('#element').tooltip('show');

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

                            <div class="sidebar-dash" style="">

                                @if ($_website == 'Nepali' || $_website == 'Both')
                                    <div class="form-group row {{ $errors->has('np_title') ? 'has-error' : '' }}">
                                        {!! Html::decode(Form::label('np_title', '<i class="fas fa-text-width"></i> Title (NP) :*', ['class' => 'col-sm-12'])) !!}
                                        <div class="col-sm-12">
                                            {{ Form::text('np_title', @$newsInfo->title['np'], ['class' => 'form-control', 'id' => 'np_title', 'placeholder' => 'News Title (in Nepali)', 'required' => true]) }}
                                            @error('np_title')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if ($_website == 'English' || $_website == 'Both')
                                    <div class="form-group row {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                        {!! Html::decode(Form::label('en_title', '<i class="fas fa-text-width"></i> Title (EN) :', ['class' => 'col-sm-12'])) !!}
                                        <div class="col-sm-12">
                                            {{ Form::text('en_title', @$newsInfo->title['en'], ['class' => 'form-control', 'maxlength' => '25', 'id' => 'en_title', 'placeholder' => 'News   Title (in English)', 'required' => true]) }}
                                            @error('en_title')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row {{ $errors->has('tagLine') ? 'has-error' : '' }}">
                                    {!! Html::decode(Form::label('tagLine', '<i class="fas fa-tag"></i> Tag Line :*', ['class' => 'col-sm-12'])) !!}
                                    <div class="col-sm-12">
                                        {{ Form::text('tagLine', @$newsInfo->tagLine, ['class' => 'form-control', 'id' => 'tagLine', 'placeholder' => 'Tag line   ']) }}
                                        @error('tagLine')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('subtitle') ? 'has-error' : '' }}">
                                    {!! Html::decode(Form::label('subtitle', '<i class="fas fa-text-height"></i> Second Heading :*', ['class' => 'col-sm-12'])) !!}
                                    <div class="col-sm-12">
                                        {{ Form::text('subtitle', @$newsInfo->subtitle, ['class' => 'form-control', 'id' => 'subtitle', 'placeholder' => 'Second Heading  ']) }}
                                        @error('subtitle')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @hasanyrole('Super Admin|Admin')
                                <div class="form-group row {{ $errors->has('reporters') ? 'has-error' : '' }}">

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            {!! Html::decode(Form::label('reporters', '<i class="fas fa-pen-nib"></i> Reporter name :*', ['class' => 'col-sm-12'])) !!}
                                            <div class="col-sm-12">
                                                {{-- {{ dd($newsInfo->get_news_reporter) }} --}}
                                                {{ Form::select('reporters[]', @$reporters,  $newsInfo   && @$newsInfo->get_news_reporter->count() ? @$newsInfo->get_news_reporter->pluck('id') : null, ['class' => 'form-control  ', 'multiple' => true, 'required' => true, 'id' => 'reporter']) }}
                                                @error('reporters')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endhasallroles

                                @hasanyrole('Super Admin|Admin')
                                <div class="form-group row {{ $errors->has('guest') ? 'has-error' : '' }}">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            {!! Html::decode(Form::label('guest', '<i class="fas fa-user-edit"></i> Guest Information :*', ['class' => 'col-sm-12'])) !!}
                                            <div class="col-sm-12">
                                                {{ Form::select('guest', @$guestlist, @$newsInfo->guestId, ['class' => 'form-control  ', 'id' => 'guest', 'placeholder' => 'Guest Name']) }}
                                                @error('guest')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="button" class="btn btn-primary mb-2 btn-xs" data-toggle="modal"
                                                data-target="#exampleModalGuest">
                                                Add Guest
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                @endhasallroles
                                {{-- {{ dd($tags) }} --}}
                                <livewire:admin.taglist :newsdata="@$newsInfo">
                                    @if ($_website == 'Nepali' || $_website == 'Both')
                                        <div
                                            class="form-group row {{ $errors->has('np_description') ? 'has-error' : '' }}">
                                            {!! Html::decode(Form::label('np_description', '<i class="fas fa-stream"></i> Content (NP) :*', ['class' => 'col-sm-12'])) !!}
                                            <div class="col-sm-12">
                                                {{ Form::textarea('np_description', @$newsInfo->description['np'], ['class' => 'form-control ckeditor', 'maxlength' => '100', 'id' => 'np_description', 'placeholder' => ' News  Description in Nepali']) }}
                                                @error('np_description')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if ($_website == 'English' || $_website == 'Both')
                                        <div
                                            class="form-group row {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                            {!! Html::decode(Form::label('en_description', '<i class="fas fa-stream"></i> Content (EN) :*', ['class' => 'col-sm-12'])) !!}
                                            <div class="col-sm-12">
                                                {{ Form::textarea('en_description', @$newsInfo->description['en'], ['class' => 'form-control ckeditor', 'id' => 'en_description', 'placeholder' => 'News Description in English', 'required' => true]) }}
                                                @error('en_description')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-md-12"><i class="fab fa-youtube"></i> Video News :*</label>
                                        <div class="btn-group btn-group-toggle col-md-3" data-toggle="buttons">
                                            <label class="btn btn-default active">
                                                <input type="radio" name="isVideo" autocomplete="off" value="1"
                                                    id="videoactive" {{ @$newsInfo->isVideo == 1 ? 'checked' : '' }}> Yes
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="isVideo" autocomplete="off" value="0"
                                                    {{ @$newsInfo->isVideo == 0 ? 'checked' : '' }}>No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="isVideo form-group row {{ $errors->has('video') ? 'has-error' : '' }}">
                                        {!! Html::decode(Form::label('embed', '<i class="fas fa-photo-video"></i> Embed Code Only :*', ['class' => 'col-sm-12'])) !!}
                                        <div class="col-sm-12">
                                            {{ Form::textarea('embed', @$newsInfo->video, ['class' => 'form-control ckeditor', 'id' => 'embed', 'placeholder' => 'News Description in English', 'required' => true]) }}
                                            @error('embed')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
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
                                    @include('admin.news.admin-add-to-read-news-form')
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="sidebar-dash" style="">

                                <div class="form-group row {{ $errors->has('published_at') ? 'has-error' : '' }}">
                                    {!! Html::decode(Form::label('published_at', '<i class="far fa-clock"></i> Scheduled Post Time :', ['class' => 'col-sm-12'])) !!}
                                    <div class="col-sm-12">

                                        {{ Form::text('published_at', @$published_at, ['id' => 'datepicker', 'required' => false, 'class' => 'form-control date']) }}

                                        @error('published_at')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                                    {!! Html::decode(Form::label('category', '<i class="fas fa-th-list"></i> News Category :*', ['class' => 'col-sm-12'])) !!}
                                    <div class="col-sm-12">

                                        {{ Form::select('category[]', @$news_category, @$newsInfo ? @$newsInfo->newsHasCategories->pluck('id') : null, ['class' => 'form-control form-control-sm ', 'id' => 'category', 'multiple' => true, 'required' => true]) }}
                                        @error('category')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {!! Html::decode(Form::label('news_image', '<i class="fas fa-images"></i> Featured Image :', ['class' => 'col-sm-8', 'style' => 'padding-left: 0px'])) !!}
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="MainImage" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="filepath"
                                                value="{{ @$newsInfo->img_url }}">
                                        </div>
                                    </div>
                                    <div id="holder" style="margin-top:15px;max-width: 100%;">
                                        <img src="{{ @$newsInfo->img_url }}" alt="" style="max-width: 100%">
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('image_caption') ? 'has-error' : '' }}">
                                    {!! Html::decode(Form::label('image_caption', '<i class="far fa-image"></i> Image Caption :', ['class' => 'col-sm-12'])) !!}
                                    <div class="col-sm-12">

                                        {{ Form::textarea('image_caption', @$newsInfo->image_caption, ['id' => 'datepicker', 'required' => false, 'class' => 'form-control date', 'rows' => 3]) }}

                                        @error('image_caption')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
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
                            </div> --}}
                                @hasanyrole('Super Admin|Admin')

                                <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                    {!! Html::decode(Form::label('publish_status', '<i class="fas fa-lock-open"></i> Publish Status :*', ['class' => 'col-sm-12'])) !!}
                                    <div class="col-sm-12">
                                        {{ Form::select('publish_status', [0 => 'Un-publish', 1 => 'publish', 2 => 'draft'], @$newsInfo->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'text-capitalize form-control']) }}
                                        @error('publish_status')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @endhasallroles
                                <div class="form-group row">
                                    <label class="col-md-12"><i class="fas fa-eye-slash"></i> Image Show</label>
                                    <div class="btn-group btn-group-toggle col-md-12" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="image_show" autocomplete="off" value="1"
                                                {{ @$newsInfo->image_show == 1 ? 'checked' : '' }}> Yes
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="image_show" autocomplete="off" value="0"
                                                {{ @$newsInfo->image_show == 0 ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="check-list radio">
                                        {!! Html::decode(Form::label('isFixed', '<i class="fab fa-autoprefixer"></i> Fixed News :*', ['class' => 'col-sm-12'])) !!}
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="isFixed" value="1" <?php echo
                                                isset($newsInfo->isFixed) ? (isset($newsInfo->isFixed) && $newsInfo->isFixed
                                            == 1 ? 'checked="checked"' : '') : 'checked="checked"'; ?>>
                                            <span class="input-span"></span>
                                            Yes
                                        </label>
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="isFixed" value="0" <?php echo
                                                isset($newsInfo->isFixed) && $newsInfo->isFixed == 0 ? 'checked="checked"' :
                                            ''; ?>>
                                            <span class="input-span"></span>
                                            No
                                        </label>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="check-list radio">
                                        {!! Html::decode(Form::label('isSpecial', '<i class="fas fa-text-width"></i> Special News :*', ['class' => 'col-sm-12'])) !!}
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="isSpecial" value="1" <?php echo
                                                isset($newsInfo->isSpecial) ? (isset($newsInfo->isSpecial) &&
                                            $newsInfo->isSpecial == 1 ? 'checked="checked"' : '') : 'checked="checked"'; ?>>
                                            <span class="input-span"></span>
                                            Yes
                                        </label>
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="isSpecial" value="0" <?php echo
                                                isset($newsInfo->isSpecial) && $newsInfo->isSpecial == 0 ?
                                            'checked="checked"' : '';
                                            if (isset($type) && $type == 'special') {
                                            echo 'disabled';
                                            }
                                            ?>>
                                            <span class="input-span"></span>
                                            No
                                        </label>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12"><i class="fas fa-eye-slash"></i> Breaking News</label>
                                    <div class="btn-group btn-group-toggle col-md-12" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="isBreaking" autocomplete="off" value="1" id="breaking"
                                                {{ @$newsInfo->isBreaking == 1 ? 'checked' : '' }}> Yes
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="isBreaking" autocomplete="off" value="0"
                                                {{ @$newsInfo->isBreaking == 0 ? 'checked' : '' }}>No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 breaking_text_position">
                                    {!! Html::decode(Form::label('text_position', '<i class="fas fa-arrows-alt"></i> Breaking News Text Position :*', ['class' => 'col-sm-12 col-md-12'])) !!}
                                    {{ Form::select('text_position', @$banner_type, @$newsInfo->text_position, ['class' => 'form-control', 'id' => 'banner', 'multiple' => false, 'required' => true]) }}
                                    @error('text_position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                    @if ($_website == 'Nepali' || $_website == 'Both')
                                    {!! Form::label('np_summary',  null) !!}
                                        {!! Form::textarea('np_summary', @$newsInfo->summary['np'], ['class' => 'form-control form-control-sm ', 'placeholder' => 'Breaking news short content']) !!}

                                        @error('np_summary')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    @endif
                                    @if ($_website == 'English' || $_website == 'Both')
                                    {!! Form::label('np_summary',  null) !!}
                                        {!! Form::textarea('en_summary', @$newsInfo->summary['np'], ['class' => 'form-control form-control-sm ', 'placeholder' => 'Breaking news short content']) !!}
                                        @error('en_summary')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>



                                <div class="col-md-12 isPhotoFeature">
                                    <div class="check-list radio">
                                        {!! Html::decode(Form::label('isPhotoFeature', '<i class="fas fa-text-width"></i> Photo Feature News :*', ['class' => 'col-sm-12'])) !!}
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="isPhotoFeature" value="1" id="photo" <?php echo isset($newsInfo->isPhotoFeature) ?
                                            (isset($newsInfo->isPhotoFeature) && $newsInfo->isPhotoFeature == 1 ?
                                            'checked="checked"' : '') : 'checked="checked"'; ?>>
                                            <span class="input-span"></span>
                                            Yes
                                        </label>
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="isPhotoFeature" value="0" <?php echo
                                                isset($newsInfo->isPhotoFeature) && $newsInfo->isPhotoFeature == 0 ?
                                            'checked="checked"' : '';
                                            if (isset($type) && $type == 'photo') {
                                            echo 'disabled';
                                            }
                                            ?>>
                                            <span class="input-span"></span>
                                            No
                                        </label>

                                    </div>
                                </div>
                                {{-- @endif --}}
                                <div class="col-md-12">
                                    <div class="check-list radio">
                                        {!! Html::decode(Form::label('mobile_notification', '<i class="fas fa-text-width"></i> Mobile Notifications:*', ['class' => 'col-sm-12'])) !!}
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="mobile_notification" value="1" <?php
                                                echo isset($newsInfo->mobile_notification) && $newsInfo->mobile_notification
                                            == 1 ? 'checked="checked"' : ''; ?>>
                                            <span class="input-span"></span>
                                            Yes
                                        </label>
                                        <label class="ui-radio ui-radio-primary">
                                            <input type="radio" name="mobile_notification" value="0" <?php
                                                echo isset($newsInfo->mobile_notification) ?
                                            (isset($newsInfo->mobile_notification) && $newsInfo->mobile_notification == 0 ?
                                            'checked="checked"' : '') : 'checked="checked"'; ?>>
                                            <span class="input-span"></span>
                                            No
                                        </label>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-12"><i class="fab fa-facebook-f"></i> Facebook Share
                                        <span class="d-inline-block" id='example' tabindex="0" data-toggle="tooltip"
                                            title="News should have published attribute for this feature to work">
                                            <span class="badge badge-pill badge-info"> ? </span>
                                        </span>
                                    </label>
                                    <div class="btn-group btn-group-toggle col-md-12" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="facebook_share" autocomplete="off" value="1"> Yes
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="facebook_share" autocomplete="off" value="0"
                                                checked="checked">No
                                        </label>
                                    </div>
                                </div>

                                {{-- {{ Form::label('special_news', 'Special News :*', ['class' => 'col-sm-12']) }}
                            <div class="form-group row col-sm-12" style ="width:100%; border:1px solid">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="special_news" id="yes" value="1">
                            <label class="form-check-label" for="yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="special_news" id="no" value="0">
                            <label class="form-check-label" for="no">No</label>
                            </div>
                            </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-sm btn-success btn-flat', 'type' => 'submit']) }}
                                        {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-sm btn-danger btn-flat', 'type' => 'reset']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalGuest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="guest-form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Guest</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="val-error-guest" class="text-danger" style="display: none">Please fill all the fields
                                below.</p>
                            <div class="form-row">
                                <div class="col">
                                    <label for="np_name" class="col-form-label">Guest's Full name:</label>
                                    <input type="text" class="form-control" id="guest-title" name="np_name"
                                        placeholder="Guest's Full name">
                                </div>

                            </div>
                            <div class="form-row">
                                <!-- <div class="col">
                                                                                        <label for="title" class="col-form-label">Slug:</label>
                                                                                        <input type="text" class="form-control" id="guest-slug" name="slug" placeholder="Enter Slug">
                                                                                    </div> -->
                                <div class="col">
                                    <label for="title" class="col-form-label">Email:</label>
                                    <input type="text" class="form-control" name="email" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="title" class="col-form-label">Address:</label>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address">
                                </div>
                                <div class="col">
                                    <label for="title" class="col-form-label">Contact No:</label>
                                    <input type="text" class="form-control" name="contact_no"
                                        placeholder="Enter Contact No">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="modal-submit-guest" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')


@endsection
