@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
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

            $(document).on('change', "#allow_to_login", function() {
                $('.user_can_login').slideToggle(200);
                // if($(this).val() == 1){
                // }
            })
            $('#lfm').filemanager('image');

            $('.user_can_login').slideToggle(200);

        </script>
        @if (!$profile_info || (@$profile_info && @$profile_info->allow_to_login))
            <script>
            </script>
        @endif
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
                        <a href="{{ route('profile.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($profile_info))
                        {{ Form::open(['url' => route('reporters.update', $profile_info->id), 'files' => true, 'class' => 'form', 'name' => 'profile_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('reporters.store'), 'files' => true, 'class' => 'form', 'name' => 'profile_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-8  ">
                            <div class="form-group row {{ $errors->has('en_name') ? 'has-error' : '' }}">
                                {{ Form::label('en_name', 'Name(in English):*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('en_name', @$profile_info->name['en'], ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('en_name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('np_name') ? 'has-error' : '' }}">
                                {{ Form::label('np_name', 'Name(in Nepali) :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('np_name', @$profile_info->name['np'], ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('np_name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('email', @$profile_info->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('email')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {{ Form::label('phone', 'Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('phone', @$profile_info->phone, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone','style' => 'width:80%']) }}
                                    @error('phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('allow_to_login') ? 'has-error' : '' }}">
                                {{ Form::label('allow_to_login', 'Allow to Login  :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('allow_to_login', ['0' => 'Can not login', '1' => 'Can login'], @$profile_info->allow_to_login, ['class' => 'form-control', 'id' => 'allow_to_login', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('allow_to_login')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if (isset($profile_info) && !$profile_info->allow_to_login)
                            <div class="user_can_login">
                                <div class="password_change">
                                    <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                                        {{ Form::label('password', 'Password:*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password', 'style' => 'width:80%']) }}
                                            @error('password')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div
                                        class="form-group row {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                                        {{ Form::label('confirm_password', 'Re-Password:*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::password('confirm_password', ['class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => 'Re-Password',   'style' => 'width:80%']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                            @if (!isset($profile_info))
                                <div class="user_can_login">
                                    <div class="password_change {{ isset($profile_info) ? 'd-none' : '' }}">
                                        <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                                            {{ Form::label('password', 'Password:*', ['class' => 'col-sm-3']) }}
                                            <div class="col-sm-9">
                                                {{ Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password', 'style' => 'width:80%']) }}
                                                @error('password')
                                                    <span class="help-block error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div
                                            class="form-group row {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                                            {{ Form::label('confirm_password', 'Re-Password:*', ['class' => 'col-sm-3']) }}
                                            <div class="col-sm-9">
                                                {{ Form::password('confirm_password', ['class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => 'Re-Password',   'style' => 'width:80%']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                                {{ Form::label('address', 'Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('address', @$profile_info->address, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Address','style' => 'width:80%']) }}
                                    @error('address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row {{ $errors->has('roles') ? 'has-error' : '' }}">
                            {{ Form::label('roles', 'User Role:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::select('roles[]', $roles, @$userRole, ['id' => 'roles', 'required' => true, 'class' => 'form-control select2', 'multiple', 'style' => 'width:80%; border-color:none']) }}
                                @error('roles')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                            <div class="form-group row {{ $errors->has('designation') ? 'has-error' : '' }}">
                                {{ Form::label('designation', 'User Designation:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('designation', @$profile_info->designation, ['class' => 'form-control', 'id' => 'designation', 'placeholder' => 'Enter User Designation (Positon)', 'required' => false, 'style' => 'width:80%']) }}
                                    @error('np_name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group row">
                                <div class="input-group">
                                    {{ Form::label('image', 'Profile Image:*', ['class' => 'col-sm-12']) }}
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="hidden" name="profile_image_url"
                                        value="{{ @$profile_info->profile_image_url }}">
                                </div>

                                <div class="col-lg-4"></div>
                                <div id="holder" style="margin-top:15px;max-width: 100%;" class="col-lg-12">
                                    <img src="{{ create_image_url(@$profile_info->profile_image_url, 'banner') }}" alt=""
                                        style="max-width: 100%">
                                </div>

                            </div>
                            <div class="form-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                                {{ Form::label('facebook', 'Facebook Link :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::text('facebook', @$profile_info->facebook, ['class' => 'form-control', 'id' => 'facebook', 'placeholder' => 'Facebook link', 'style' => 'width:80%']) }}
                                    @error('facebook')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('twitter', 'Twitter Link :*', ['style' => 'padding: 6px']) }}
                                <div class="col-sm-12">
                                    {{ Form::text('twitter', @$profile_info->twitter, ['class' => 'form-control', 'id' => 'twitter', 'placeholder' => 'Twitter link', 'style' => 'width:80%']) }}
                                    @error('twitter')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$profile_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
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
