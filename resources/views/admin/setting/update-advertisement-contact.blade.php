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

    @endpush
@section('content')



    {{ Form::open(['url' => route('updateAdvertisemntDetail'), 'files' => true, 'class' => 'form-horizontal', 'name' => 'appsetting_form']) }}

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
