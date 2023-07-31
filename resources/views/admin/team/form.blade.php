@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/member.js') }}"></script>
        <script>
            $('#MainImage').filemanager('image');

        </script>
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
                        <a href="{{ route('team.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($team_info))
                        {{ Form::open(['url' => route('team.update', $team_info->id), 'files' => true, 'class' => 'form', 'name' => 'member_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('team.store'), 'files' => true, 'class' => 'form', 'name' => 'member_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                        <div class="col-sm-10 offset-lg-1">
                            {{-- {{ dd($team_info) }} --}}
                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_full_name') ? 'has-error' : '' }}">
                                    {{ Form::label('en_full_name', 'English Full Name (EN):*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('en_full_name', @$team_info->full_name['en'], ['class' => 'form-control', 'id' => 'en_full_name', 'placeholder' => 'English Full Name', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('en_full_name')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('np_full_name') ? 'has-error' : '' }}">
                                    {{ Form::label('np_full_name', 'Nepali Full Name (NP):*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('np_full_name', @$team_info->full_name['np'], ['class' => 'form-control', 'id' => 'np_full_name', 'placeholder' => 'Nepali Full Name', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('np_full_name')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row {{ $errors->has('designation_id') ? 'has-error' : '' }}">
                                {{ Form::label('designation_id', 'Designation :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('designation_id', @$designations, @$team_info->designation_id, ['id' => 'designation', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('Comm_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {{ Form::label('phone', 'Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('phone', @$team_info->phone, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'phone', 'style' => 'width:80%']) }}
                                    @error('phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                                {{ Form::label('address', 'Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('address', @$team_info->address, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Address', 'style' => 'width:80%']) }}
                                    @error('address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('email', @$team_info->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email', 'style' => 'width:80%']) }}
                                    @error('email')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                                {{ Form::label('facebook', 'Facebook URL :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('facebook', @$team_info->facebook, ['class' => 'form-control', 'id' => 'facebook url', 'placeholder' => 'facebook', 'style' => 'width:80%']) }}
                                    @error('facebook')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('twitter') ? 'has-error' : '' }}">
                                {{ Form::label('twitter', 'Twitter URL :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('twitter', @$team_info->twitter, ['class' => 'form-control', 'id' => 'twitter url', 'placeholder' => 'twitter', 'style' => 'width:80%']) }}
                                    @error('twitter')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('youtube') ? 'has-error' : '' }}">
                                {{ Form::label('youtube', 'Youtube URL :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('youtube', @$team_info->youtube, ['class' => 'form-control', 'id' => 'youtube url', 'placeholder' => 'Youtube URL', 'style' => 'width:80%']) }}
                                    @error('youtube')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('instagram') ? 'has-error' : '' }}">
                                {{ Form::label('instagram', 'Instagram URL :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('instagram', @$team_info->instagram, ['class' => 'form-control', 'id' => 'instagram url', 'placeholder' => 'Instagram URL', 'style' => 'width:80%']) }}
                                    @error('instagram')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row {{ $errors->has('show_footer') ? 'has-error' : '' }}">
                                {{ Form::label('show_footer', 'Display On bottom of the website :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('show_footer', [1 => 'Display', 0 => 'Do not Display'], @$team_info->show_footer, ['id' => 'show_footer', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('show_footer')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if ($_website == 'English' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                    {{ Form::label('en_description', 'Description(EN) :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::textarea('en_description', @$team_info->description['en'], ['class' => 'form-control ckeditor', 'id' => 'my-editor1', 'placeholder' => 'Feature Long Description', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('en_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($_website == 'Nepali' || $_website == 'Both')
                                <div class="form-group row {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                    {{ Form::label('np_description', 'Description(NP) :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::textarea('np_description', @$team_info->description['np'], ['class' => 'form-control ckeditor', 'id' => 'my-editor1', 'placeholder' => 'Feature Long Description', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('np_description')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                {{ Form::label('filepath', 'Image', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="MainImage" data-input="thumbnail" data-preview="holder"
                                                class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="filepath"
                                            value="{{ @$team_info->image }}">
                                    </div>
                                    <div id="holder" style="border-radius: 4px;
                                            padding: 5px;
                                            width: 150px;
                                            margin-top:15px;"></div>
                                    <img src="{{ @$team_info->image }}" alt="" style="max-width: 100px">
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$team_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                    <span class="help-block error">{{ $message }}</span>
                                    @enderror
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
