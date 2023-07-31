@extends('layouts.admin')
@section('title', $title)
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/benefit.js') }}"></script> --}}
    <script>
    $('#lfm').filemanager('image');
    $(document).ready(function() {
        $('#type').select2({
            placeholder: "Select Container Type",
         });
        $('#publish_status').select2();
    })
    </script>
    @include('admin.section.ckeditor')
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
                        <a href="{{ route('counter.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                {{-- {{dd($counter_info->happy_client['value'])}} --}}
                {{-- @include('admin.shared.error-messages') --}}
                <div class="card-body">
                    @if (isset($counter_info))
                        {{ Form::open(['url' => route('counter.update', $counter_info->id), 'files' => true, 'class' => 'form', 'name' => 'container_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('counter.store'), 'files' => true, 'class' => 'form', 'name' => 'container_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('happy_client') ? 'has-error' : '' }}">
                                {{ Form::label('happy_client', 'Happy Clients :*', ['class' => 'col-sm-2']) }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::number('happy_client_value', @$counter_info->happy_client['value'], ['class' => 'form-control', 'id' => 'happy_client', 'placeholder' => 'Enter Value',  'style' => 'width:min-content']) }}

                                    </div>
                                    <div class="col-lg-4">
                                        {{ Form::text('happy_client_icon', @$counter_info->happy_client['icon'], ['class' => 'form-control', 'id' => 'icon', 'placeholder' => 'fa fa-cloud-upload', 'style' => 'width:100%']) }}

                                    </div>
                                    <div class="col-lg-2">
                                        <i class="{{@$counter_info->happy_client['icon']}}"></i>
                                    </div>

                                    @error('happy_client')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('skil_export') ? 'has-error' : '' }}">
                                {{ Form::label('skil_export', 'Skill Experts :*', ['class' => 'col-sm-2']) }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::number('skil_export_value', @$counter_info->skil_export['value'], ['class' => 'form-control', 'id' => 'skil_export_value', 'placeholder' => 'Enter Value',  'style' => 'width:max-content']) }}

                                    </div>
                                    <div class="col-lg-4">
                                        {{ Form::text('skil_export_icon', @$counter_info->skil_export['icon'], ['class' => 'form-control', 'id' => 'skil_export_icon', 'placeholder' => 'fa fa-cloud-upload', 'style' => 'width:100%']) }}

                                    </div>
                                    <div class="col-lg-2">
                                        <i class="{{@$counter_info->skil_export['icon']}}"></i>
                                    </div>

                                    @error('skil_export')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('finesh_project') ? 'has-error' : '' }}">
                                {{ Form::label('finesh_project', 'Finished Projects :*', ['class' => 'col-sm-2']) }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::number('finesh_project_value', @$counter_info->finesh_project['value'], ['class' => 'form-control', 'id' => 'finesh_project_value', 'placeholder' => 'Enter Value',  'style' => 'width:max-content']) }}

                                    </div>
                                    <div class="col-lg-4">
                                        {{ Form::text('finesh_project_icon', @$counter_info->finesh_project['icon'], ['class' => 'form-control', 'id' => 'finesh_project_icon', 'placeholder' => 'fa fa-cloud-upload', 'style' => 'width:100%']) }}

                                    </div>
                                    <div class="col-lg-2">
                                        <i class="{{@$counter_info->finesh_project['icon']}}"></i>
                                    </div>

                                    @error('finesh_project')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('media_post') ? 'has-error' : '' }}">
                                {{ Form::label('media_post', 'Media Posts :*', ['class' => 'col-sm-2']) }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::number('media_post_value', @$counter_info->media_post['value'], ['class' => 'form-control', 'id' => 'media_post_value', 'placeholder' => 'Enter Value',  'style' => 'width:max-content']) }}

                                    </div>
                                    <div class="col-lg-4">
                                        {{ Form::text('media_post_icon', @$counter_info->media_post['icon'], ['class' => 'form-control', 'id' => 'media_post_icon', 'placeholder' => 'fa fa-cloud-upload', 'style' => 'width:100%']) }}

                                    </div>
                                    <div class="col-lg-2">
                                        <i class="{{@$counter_info->media_post['icon']}}"></i>
                                    </div>

                                    @error('media_post')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$counter_info->publish_status, ['id' => 'publish_status',  'class' => 'form-control', 'style' => 'width:50%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                                {{ Form::label('', '', ['class' => 'col-sm-2']) }}
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
