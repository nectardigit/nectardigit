@extends('layouts.admin')
@section('title', 'Basic Site Settings')
    @push('styles')
        <style>
            .btn-default.active,
            .btn-default.active:hover {
                background-color: #17a2b8;
                border-color: #138192;
                color: #fff;
            }

        </style>
    @endpush
    @push('scripts')
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/appsetting.js') }}"></script>
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $(document).ready(function() {
                // $('#lfm').change(function() {
                //     $('#thumbnail').removeClass('d-none');
                // })
                $('#favicon').change(function() {
                    $('#favicon_image').removeClass('d-none');

                })
                $('#og_image').change(function() {
                    $('#og_image_preview').removeClass('d-none');

                })
            });

            $('#lfm').filemanager('image');
            $('#favicon_button').filemanager('image');
            $('#og_image_button').filemanager('image');

        </script>
        <script>
            $(document).ready(function() {
                $('#filepath_app_button').filemanager('image');


                $('#filepath_app').change(function() {
                    // alert('hello');
                    var input = this;
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $('#filepath_app_view').attr('src', e.target.result).fadeIn(1000);
                            $('#filepath_app_view').removeClass('d-none');
                            // $('#img_edit').addClass('d-none');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                })
            })

        </script>
        <script>
            UpdateMeta("{{ @$site_detail->is_meta == 1 ? 'YES' : 'NO' }}");
            UpdateFavOg("{{ @$site_detail->is_favicon == 1 ? 'YES' : 'NO' }}");
            UpdateStartAd("{{ @$site_detail->is_startup_ad == 1 ? 'YES' : 'NO' }}");

        </script>
    @endpush
@section('content')


    @if (@$site_detail)
        {{ Form::open(['url' => route('setting.update', @$site_detail->id), 'files' => true, 'class' => 'form-horizontal', 'name' => 'appsetting_form']) }}
        @method('put')
    @else
        {{ Form::open(['url' => route('setting.store'), 'files' => true, 'class' => 'form-horizontal', 'name' => 'appsetting_form']) }}
    @endif
    <div class="card-body">
        @csrf
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                            href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                            aria-selected="true">Company</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                            href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                            aria-selected="false">URLs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill"
                            href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages"
                            aria-selected="false">Web</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-meta-tab" data-toggle="pill"
                            href="#custom-tabs-three-meta" role="tab" aria-controls="custom-tabs-three-messages"
                            aria-selected="false">Meta</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">
                        <div class="form-group row">
                            {{ Form::label('name', 'Office Name*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('name', @$site_detail->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Office Name', 'required' => false]) }}
                                @error('name')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('address', 'Office Address*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('address', @$site_detail->address, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Office Address', 'required' => false]) }}
                                @error('address')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('map_url', 'Office Google Map URL*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('map_url', @$site_detail->map_url, ['class' => 'form-control', 'id' => 'map_url', 'placeholder' => 'Office Embed Map URL', 'required' => false]) }}
                                @error('map_url')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('embedded_url', 'Office Embedded Map URL*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('embedded_url', @$site_detail->embedded_url, ['class' => 'form-control', 'id' => 'embedded_url', 'placeholder' => 'Office Embed Map URL', 'required' => false]) }}
                                @error('embedded_url')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('email', 'Oficial Email*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('email', @$site_detail->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Oficial Email', 'required' => false]) }}
                                @error('email')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('registration_date', 'Registration Date', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::date('registration_date', @$site_detail->registration_date, ['class' => 'form-control', 'id' => 'registration_date', 'placeholder' => 'registration date', 'required' => false]) }}
                                @error('registration_date')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('registration_number', 'Registration Number', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('registration_number', @$site_detail->registration_number, ['class' => 'form-control', 'id' => 'registration_number', 'placeholder' => 'registration number', 'required' => false]) }}
                                @error('registration_number')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('phone_number', 'Primary Phone Number*', ['class' => 'col-sm-4 col-form-label', 'required' => false]) }}
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{-- {{ dd($site_detail) }} --}}
                                        {{ Form::text('contact_no[0][phone_number]', @$site_detail->phone[0]['phone_number'], ['class' => 'form-control', 'maxlength' => 10, 'id' => 'phone', 'placeholder' => 'Primary Phone Number ']) }}
                                        @error('phone')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-lg-6">
                                        {!! Form::text('contact_no[0][contact_city]', @$site_detail->phone[0]['contact_city'], ['class' => 'form-control', 'placeholder' => 'Contact City name ']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('phone_number_one', 'Phone Number One (Optional)', ['class' => 'col-sm-4 col-form-label', 'required' => false]) }}
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::text('contact_no[1][phone_number]', @$site_detail->phone[1]['phone_number'], ['class' => 'form-control', 'maxlength' => 10, 'id' => 'phone', 'placeholder' => 'Phone Number One']) }}
                                        @error('phone')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        {!! Form::text('contact_no[1][contact_city]', @$site_detail->phone[1]['contact_city'], ['class' => 'form-control', 'placeholder' => 'Contact City name ']) !!}

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- <div class="form-group row">
                                    {{ Form::label('logo', 'Official Logo*', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-sm-8">
                                        {{ Form::file('logo', ['id' => 'logo', 'class' => 'd-block mb-2', 'accept' => 'image/*']) }}
                                        @error('logo_url')
                                                    <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                        <img id="image_view" src="#" alt="image" class="d-none img-fluid img-thumbnail"
                                            style="height: 80px" />
                                        <div class="col-sm-4">
                                            @if (isset($site_detail->logo_url))
                                                @if (file_exists(public_path() . '/uploads/settings/' . @$site_detail->logo_url))
                                                    <img src="{{ asset('/uploads/settings/' . @$site_detail->logo_url) }}"
                                                        alt="{{ $site_detail->logo_url }}" class="img img-fluid img-thumbnail"
                                                        style="height:80px" id="img_edit">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div> -->
                        {{-- <div class="form-group row">
                        <div class="input-group">
                            {{ Form::label('logo', 'Official Logo*', ['class' => 'col-sm-4 col-form-label']) }}
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" name="filepath" value="{{ @$site_detail->logo }}">
                        </div>

                        <div class="col-lg-4"></div>
                        <div id="holder" style="margin-top:15px;" class="col-lg-3 offset-col-lg-5">
                            <img src="{{ @$site_detail->logo }}" alt="" style="max-width: 100%">
                        </div>

                    </div> --}}
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group row">
                                    {{ Form::label('filepath_app', 'Image for App (optional):', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-lg-6">
                                        <span class="input-group-btn">
                                            <a id="filepath_app_button" data-input="thumbnail" data-preview="filepath_app_holder"
                                                class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Upload Logo
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="hidden" name="logo_url"
                                            value="{{ @$site_detail->logo_url }}">

                                    </div>
                                    <div class="col-lg-4 offset-lg-4">
                                        <div id="filepath_app_holder" style="margin-top:15px;max-width: 100%;">
                                            <img src="{{ @$site_detail->logo_url }}" alt="" style="max-width: 40%">
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                        {{-- <div class="form-group row">
                        <label class="col-md-4">Favicon / OG Image</label>
                        <div class="btn-group btn-group-toggle col-md-3" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="is_favicon" autocomplete="off" value="YES" {{ @$site_detail->is_favicon == 1 ? 'checked' : '' }}> Yes
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="is_favicon" autocomplete="off" value="NO" {{ @$site_detail->is_favicon == 0 ? 'checked' : '' }}>No
                            </label>
                        </div>
                    </div> --}}

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group row">

                                    {{ Form::label('favicon', 'Image for App (optional):', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-lg-6">
                                        <span class="input-group-btn">
                                            <a id="favicon_button" data-input="favicon_image" data-preview="favicon_holder"
                                                class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Fab icon (icon on browser tab)
                                            </a>
                                        </span>
                                        <input id="favicon_image" class="form-control" type="hidden" name="favicon"
                                            value="{{ @$site_detail->favicon }}">

                                    </div>
                                    <div class="col-lg-4 offset-lg-4">
                                        <div id="favicon_holder" style="margin-top:15px;max-width: 100%;">
                                            <img src="{{ @$site_detail->favicon }}" alt="" style="max-width: 40%">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group row">
                                    {{ Form::label('og_image', 'OG Image:', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-lg-6">
                                        <span class="input-group-btn">
                                            <a id="og_image_button" data-input="og_image_preview"
                                                data-preview="og_image_holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Upload og image
                                            </a>
                                        </span>
                                        <input id="og_image_preview" class="form-control" type="hidden" name="og_image"
                                            value="{{ @$site_detail->og_image }}">

                                    </div>
                                    <div class="col-lg-4 offset-lg-4">
                                        <div id="og_image_holder" style="margin-top:15px;max-width: 100%;">
                                            <img src="{{ @$site_detail->og_image }}" alt="" style="max-width: 40%">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        {{-- <div class="form-group row">


                    </div>

                    <div class="form-group row">

                    </div>
                    <div id="fav_icon-details">
                    </div> --}}


                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-three-profile-tab">

                        {{-- <div class="form-group row">
                            {{ Form::label('app_url', '  App URL*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('app_url', @$site_detail->app_url, ['class' => 'form-control', 'id' => 'app_url', 'placeholder' => 'Android App URL', 'required' => false]) }}
                                @error('app_url')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}


                        <div class="form-group row">
                            {{ Form::label('twitter', 'Official Twitter', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('twitter', @$site_detail->twitter, ['class' => 'form-control', 'id' => 'twitter', 'placeholder' => 'Official Twitter(Eg.https://twitter.com/shrivahan)', 'required' => false]) }}
                                @error('twitter')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('facebook', 'Official Facebook', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('facebook', @$site_detail->facebook, ['class' => 'form-control', 'id' => 'facebook', 'placeholder' => 'Official Facebook (Eg.https://facebook.com/shrivahan)', 'required' => false]) }}
                                @error('facebook')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('youtube', 'Official Youtube', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('youtube', @$site_detail->youtube, ['class' => 'form-control', 'id' => 'youtube', 'placeholder' => 'Official Youtue (Eg.https://youtube.com/channel_url)', 'required' => false]) }}
                                @error('youtube')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('linkedIn', 'Official linkedIn', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('linkedIn', @$site_detail->linkedIn, ['class' => 'form-control', 'id' => 'linkedIn', 'placeholder' => 'Official LinkedIn Url', 'required' => false]) }}
                                @error('linkedIn')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('instagram', 'Official instagram', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('instagram', @$site_detail->instagram, ['class' => 'form-control', 'id' => 'instagram', 'placeholder' => 'Official instagram id', 'required' => false]) }}
                                @error('instagram')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel"
                        aria-labelledby="custom-tabs-three-messages-tab">


                        <div class="page-description-div">
                            <div class="form-group row">
                                {{ Form::label('front_feature_description', 'Front Feature Description', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::text('front_feature_description', @$site_detail->front_feature_description, ['class' => 'form-control', 'id' => 'front_feature_description', 'placeholder' => 'Front Feature Description', 'required' => false]) }}
                                    @error('front_feature_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('front_counter_description', 'Front Counter Description', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::text('front_counter_description', @$site_detail->front_counter_description, ['class' => 'form-control', 'id' => 'front_counter_description', 'placeholder' => 'Front Counter Description', 'required' => false]) }}
                                    @error('front_counter_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('front_testimonial_description', 'Front Testimonial Description', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::text('front_testimonial_description', @$site_detail->front_testimonial_description, ['class' => 'form-control', 'id' => 'front_testimonial_description', 'placeholder' => 'Front Testimonial Description', 'required' => false]) }}
                                    @error('front_testimonial_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                {{ Form::label('app_image', '  App Image', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-8">
                                    {{ Form::file('app_image', ['id' => 'app_image', 'required' => false, 'class' => 'd-block mb-2', 'accept' => 'image/*']) }}
                                    @error('app_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                    <img id="app_image_view" src="#" alt="image" class="d-none img-fluid img-thumbnail"
                                        style="height: 80px" />

                                    @if (isset($site_detail->app_image))
                                        @if (file_exists(public_path() . '/uploads/settings/' . @$site_detail->app_image))
                                            <img src="{{ asset('/uploads/settings/' . @$site_detail->app_image) }}"
                                                alt="{{ $site_detail->app_image }}" class="img img-fluid img-thumbnail"
                                                style="height:80px;">
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('banner_news', 'Banner News Number', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::number('banner_news', @$site_detail->banner_news, ['class' => 'form-control', 'id' => 'banner_news', 'placeholder' => 'Number of news to show in home page', 'required' => false, 'min' => 1]) }}
                                    @error('banner_news')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4">Startup Advertisement</label>
                                <div class="btn-group btn-group-toggle col-md-3" data-toggle="buttons">
                                    <label class="btn btn-default active">
                                        <input type="radio" name="is_startup_ad" autocomplete="off" value="1"
                                            {{ @$site_detail->is_startup_ad == 1 ? 'checked' : '' }}> Yes
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="is_startup_ad" autocomplete="off" value="0"
                                            {{ @$site_detail->is_startup_ad == 0 ? 'checked' : '' }}>No
                                    </label>
                                </div>
                            </div>
                            <div id="startUpAdNumber">
                                <div class="form-group row">
                                    {{ Form::label('startup_ad_number', 'Sartup Ad Number', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-sm-6">
                                        {{ Form::number('startup_ad_number', @$site_detail->startup_ad_number, ['class' => 'form-control', 'id' => 'startup_ad_number', 'placeholder' => 'Number of Startup Ad to show', 'required' => false, 'min' => 1]) }}
                                        @error('startup_ad_number')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-meta" role="tabpanel"
                        aria-labelledby="custom-tabs-three-meta-tab">


                        <div class="page-description-div">


                            <div class="form-group row">
                                <label class="col-md-4">Use Meta Tag</label>
                                <div class="btn-group btn-group-toggle col-md-3" data-toggle="buttons">
                                    <label class="btn btn-default active">
                                        <input type="radio" name="is_meta" autocomplete="off" value="YES"
                                            {{ @$site_detail->is_meta == 1 ? 'checked' : '' }}> Yes
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="is_meta" autocomplete="off" value="NO"
                                            {{ @$site_detail->is_meta == 0 ? 'checked' : '' }}> No
                                    </label>
                                </div>
                            </div>

                            <div id="metatag-details">
                                <div class="form-group row">
                                    {{ Form::label('meta_title', 'Meta Title', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-sm-6">
                                        {{ Form::textarea('meta_title', @$site_detail->meta_title, ['class' => 'form-control', 'id' => 'meta_title', 'placeholder' => 'Meta Title', 'required' => false, 'rows' => 1]) }}
                                        @error('meta_title')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{ Form::label('meta_key', 'Meta Keywords', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-sm-6">
                                        {{ Form::textarea('meta_key', @$site_detail->meta_keyword, ['class' => 'form-control', 'id' => 'meta_key', 'placeholder' => 'Meta Keywords', 'required' => false, 'rows' => 2]) }}
                                        @error('meta_key')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{ Form::label('meta_desc', 'Meta Description', ['class' => 'col-sm-4 col-form-label']) }}
                                    <div class="col-sm-6">
                                        {{ Form::textarea('meta_desc', @$site_detail->meta_description, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Meta Description', 'required' => false, 'rows' => 5, 'style' => 'font-size:14px; text-align:justify']) }}
                                        @error('meta_desc')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        {{ Form::button("<i class='fa fa-paper-plane'></i> Save Seting", ['class' => 'btn btn-success', 'type' => 'submit']) }}
        <a href="{{ route('dashboard.index') }}" class="btn btn-primary float-right"><i class="fa fa-list"></i>
            Dashboard</a>
    </div>
    {{ Form::close() }}

@endsection
