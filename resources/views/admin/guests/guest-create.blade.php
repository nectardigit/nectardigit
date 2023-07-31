@extends('layouts.admin')
@section('title', $pageTitle)
@push('scripts')
@include('admin.section.ckeditor')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#mainImage').filemanager('image');
    $(document).ready(function() {
        $('#category').select2({
            placeholder: "News Category",
        });
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
                    <a href="{{ route('guests.index') }}" class="btn btn-success btn-sm btn-flat mr-2">
                        Guest list
                    </a>
                    <a href="{{ route('news.index') }}" type="button" class="btn btn-tool">
                        <i class="fa fa-list"></i></a>
                </div>
            </div>

            @include('admin.shared.error-messages')
            <div class="card-body">
                

                @if (isset($guestInfo))
                {{ Form::open(['url' => route('guests.update', $guestInfo->id), 'files' => true, 'class' => 'form', 'name' => 'dataForm']) }}
                @method('put')
                @else
                {{ Form::open(['url' => route('guests.store'), 'files' => true, 'class' => 'form', 'name' => 'dataForm']) }}
                @endif
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            @if ($_website == 'Nepali' || $_website == 'Both')
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('np_name') ? 'has-error' : '' }}">
                                    {{ Form::label('np_name', "Guest's Full name  (In Nepali ) :*", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('np_name', @$guestInfo->name['np'], ['class' => 'form-control', 'id' => 'np_name', 'placeholder' => "Guest's Full name  (In Nepali ) :*", 'required' => true, 'style' => 'width:80%']) }}
                                        @error('np_name')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> 
                            </div>
                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('en_name') ? 'has-error' : '' }}">
                                    {{ Form::label('en_name', "Guest's Full name  (In English ) :*", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('en_name', @$guestInfo->name['en'], ['class' => 'form-control', 'maxlength' => '25', 'id' => 'en_name', 'placeholder' => "Guest's Full name  (In English ) :*", 'style' => 'width:80%']) }}
                                        @error('en_name')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($_website == 'Nepali' || $_website == 'Both')
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('np_position') ? 'has-error' : '' }}">
                                    {{ Form::label('np_position', "Guest's Position  (In Nepali ) :*", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('np_position', @$guestInfo->position['en'], ['class' => 'form-control', 'maxlength' => '25', 'id' => 'np_position', 'placeholder' => "Guest's Postion  (In Nepali ) :*", 'style' => 'width:80%']) }}
                                        @error('np_position')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('en_position') ? 'has-error' : '' }}">
                                    {{ Form::label('en_position', "Guest's Position  (In English ) :*", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('en_position', @$guestInfo->position['en'], ['class' => 'form-control', 'maxlength' => '25', 'id' => 'en_position', 'placeholder' => "Guest's Postion  (In English ) :*", 'style' => 'width:80%']) }}
                                        @error('en_position')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($_website == 'Nepali' || $_website == 'Both')
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('np_organization') ? 'has-error' : '' }}">
                                    {{ Form::label('np_organization', "Organization  (In Nepali ) :*", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('np_organization', @$guestInfo->organization['en'], ['class' => 'form-control', 'maxlength' => '25', 'id' => 'np_organization', 'placeholder' => "Organization  (In Nepali ) :*", 'style' => 'width:80%']) }}
                                        @error('np_organization')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($_website == 'English' || $_website == 'Both')
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('en_organization') ? 'has-error' : '' }}">
                                    {{ Form::label('en_organization', "Organization  (In English ) :*", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('en_organization', @$guestInfo->organization['en'], ['class' => 'form-control', 'maxlength' => '25', 'id' => 'en_organization', 'placeholder' => "Organization  (In English ) :*", 'style' => 'width:80%']) }}
                                        @error('en_organization')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
        
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                                    {{ Form::label('contact_no', "Contact No :", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::number('contact_no', @$guestInfo->contact_no, ['class' => 'form-control',  'id' => 'contact_no', 'placeholder' => "Contact No", 'style' => 'width:80%']) }}
                                        @error('contact_no')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                                    {{ Form::label('address', "Address :", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('address', @$guestInfo->address, ['class' => 'form-control',  'id' => 'address', 'placeholder' => "Address", 'style' => 'width:80%']) }}
                                        @error('address')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {{ Form::label('email', "Email :", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::email('email', @$guestInfo->email, ['class' => 'form-control',  'id' => 'email', 'placeholder' => "Email", 'style' => 'width:80%']) }}
                                        @error('email')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    {{ Form::label('slug', "Slug :", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('slug', @$guestInfo->slug, ['class' => 'form-control',  'id' => 'slug', 'placeholder' => "Slug", 'style' => 'width:80%']) }}
                                        @error('slug')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('slug_url') ? 'has-error' : '' }}">
                                    {{ Form::label('slug_url', "Slug URL:", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::text('slug_url', @$guestInfo->slug_url, ['class' => 'form-control',  'id' => 'slug_url', 'placeholder' => "Slug URL", 'style' => 'width:80%']) }}
                                        @error('slug_url')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                                    {{ Form::label('facebook', "Facebook :", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::email('facebook', @$guestInfo->facebook, ['class' => 'form-control',  'id' => 'facebook', 'placeholder' => "Facebook", 'style' => 'width:80%']) }}
                                        @error('facebook')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row {{ $errors->has('twitter') ? 'has-error' : '' }}">
                                    {{ Form::label('twitter', "Twitter :", ['class' => 'col-sm-12']) }}
                                    <div class="col-sm-12">
                                        {{ Form::email('twitter', @$guestInfo->twitter, ['class' => 'form-control',  'id' => 'twitter', 'placeholder' => "Twitter", 'style' => 'width:80%']) }}
                                        @error('twitter')
                                        <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
        
                            <div class="form-group row {{ $errors->has('guest_description') ? 'has-error' : '' }}">
                                {{ Form::label('guest_description', ' Guest Description  :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::textarea('guest_description', @$guestInfo->guest_description, ['class' => 'form-control ckeditor', 'id' => 'guest_description', 'placeholder' => 'Guest Description', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('guest_description')
                                    <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
        
        
        
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group row">
                            {{ Form::label('filepath', 'Image:*', ['class' => 'col-sm-12']) }}
                            <div class="input-group" style="width: max-content;">
                                <span class="input-group-btn">
                                    <a id="mainImage" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="filepath" value="{{ @$guestInfo->image_url }}">
                            </div>
                            <div id="holder" style="margin-top:15px;max-width: 100%;">
                                <img src="{{ @$guestInfo->image_thumb_url }}" alt="" style="max-width: 100%">
                            </div>
                        </div>
        
                        <div class="form-group  {{ $errors->has('publish_status') ? 'has-error' : '' }}" style="width: max-content;">
                            {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-12']) }}
                            <div class="col-sm-12">
                                {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$guestInfo->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:90%']) }}
                                @error('publish_status')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('', '', ['class' => 'col-sm-12']) }}
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
