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

        <script>
            $(document).ready(function() {
                $(function() {
                    // Initialize form validation on the registration form.
                    // It has the name attribute "registration"
                    $("form[name='menu_form']").validate({
                        // Specify validation rules
                        rules: {
                            title: "required",
                            slug: "required",
                            publish_status: "required",

                        },
                        // Specify validation error messages
                        messages: {
                            title: "Please enter title",
                            slug: "Slug is required",
                            publish_status: "Status is required",

                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                });
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
                    @if (isset($data))
                        {{ Form::open(['url' => route('usefullinks.update', $data->id), 'files' => true, 'class' => 'form', 'name' => 'menu_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('usefullinks.store'), 'files' => true, 'class' => 'form', 'name' => 'menu_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-lg-9">
                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('np_title') ? 'has-error' : '' }}">
                                    {{ Form::label('np_title', 'Useful Link Title in Nepali:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        @if (isset($data))
                                            {{ Form::text('np_title', @$data->title['np'], ['class' => 'form-control', 'id' => 'np_title', 'placeholder' => 'Enter Useful Link Title', 'required' => true, 'style' => 'width:80%', 'readonly']) }}
                                        @else
                                            {{ Form::text('np_title', @$data->title['np'], ['class' => 'form-control', 'id' => 'np_title', 'placeholder' => 'Enter Useful Link Title', 'required' => true, 'style' => 'width:80%']) }}

                                        @endif
                                        @error('np_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                    {{ Form::label('en_title', 'Menu Title in English:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        @if (isset($data))
                                            {{ Form::text('en_title', @$data->title['en'], ['class' => 'form-control', 'id' => 'en_title', 'placeholder' => 'Enter Menu Title', 'required' => true, 'style' => 'width:80%', 'readonly']) }}

                                        @else
                                            {{ Form::text('en_title', @$data->title['en'], ['class' => 'form-control', 'id' => 'en_title', 'placeholder' => 'Enter Menu Title', 'required' => true, 'style' => 'width:80%']) }}

                                        @endif
                                        @error('en_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row {{ $errors->has('content_type') ? 'has-error' : '' }}">
                                {{ Form::label('content_type', 'Content Type :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('content_type', ['basicpage' => 'basic page'], 'basicpage', ['id' => 'slug', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}


                                    @error('content_type')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row {{ $errors->has('show_on') ? 'has-error' : '' }}">
                                {{ Form::label('show_on', 'Show On :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('show_on', ['useful_links' => 'Useful Links'], 'useful_links', ['id' => 'show_on', 'required' => true, 'class' => 'form-control', 'multiple' => false, 'style' => 'width:80%']) }}
                                    @error('show_on')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('external_url') ? 'has-error' : '' }}">
                                {{ Form::label('external_url', 'Useful link Url:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('external_url', @$data->external_url, ['class' => 'form-control form-control', 'id' => 'external_url', 'placeholder' => 'Useful link Url', 'style' => 'width:80%']) }}
                                    {{-- <small class="text-danger">Enter only if you need to redirect it to external
                                        link</small> --}}
                                    @error('external_url')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                        </div>
                        <div class="col-lg-3 col-sm-12">



                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Useful link Publish Status:*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('publish_status', ['0' => 'In-Active', '1' => 'Active'], @$data->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-12">
                                    {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-sm btn-success btn-flat', 'type' => 'submit']) }}
                                    {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-sm btn-danger btn-flat', 'type' => 'reset']) }}
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
