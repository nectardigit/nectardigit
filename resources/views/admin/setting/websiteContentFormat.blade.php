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
         
    @endpush
@section('content')

    {{ Form::open(['url' => route('setupWebsiteContentFormat'), 'class' => 'form-horizontal', 'name' => 'appsetting_form']) }}

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
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">
                        <div class="form-group row">
                            <label class="col-md-12">Setup Content Language Of Website</label>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="btn-group btn-group-toggle col-md-6" data-toggle="buttons">
                                        <label class="btn btn-default   {{ @$appsetting->website_content_format == 'English' ? 'active' : '' }}">
                                            <input type="radio" name="website_content_format" autocomplete="off" value="English"
                                                {{ @$appsetting->website_content_format == 'English' ? 'checked' : '' }}>
                                            English
                                        </label>
                                        <label class="btn btn-default  {{ @$appsetting->website_content_format == 'Nepali' ? 'active' : '' }}">
                                            <input type="radio" name="website_content_format" autocomplete="off"
                                                value="Nepali"
                                                {{ @$appsetting->website_content_format == 'Nepali' ? 'checked' : '' }}>Nepali
                                        </label>
                                        <label class="btn btn-default  {{ @$appsetting->website_content_format == 'Both' ? 'active' : '' }}">
                                            <input type="radio" name="website_content_format" autocomplete="off"
                                                value="Both"
                                                {{ @$appsetting->website_content_format == 'Both' ? 'checked' : '' }}>Both
                                            (English & Nepali )
                                        </label>
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
