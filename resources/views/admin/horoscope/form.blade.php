@extends('layouts.admin')
@section('title', 'Update Horosope')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('/plugins/nepali_datepicker/nepali.datepicker.v3.2.min.css') }}" rel="stylesheet"
          type="text/css"/>

@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
    <script src="{{ asset('/plugins/nepali_datepicker/nepali.datepicker.v3.2.min.js') }}"></script>
    {{-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> --}}
    <script src="{{ asset('assets/datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/custom/information.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#image').change(function () {
                $('#thumbnail').removeClass('d-none');
            })

            $(document).on('click', '.btn_remove', function () {
                $(this).closest('div').remove();
            });
        });
        $(document).ready(function () {
            var mainInput = document.getElementById("nepali-datepicker");

            /* Initialize Datepicker with options */
            // mainInput.nepaliDatePicker();
            mainInput.nepaliDatePicker({
                dateFormat: "YYYY-MM-DD",
                dateString: "2067-12-25"
            });
            $("#startWeekDay").nepaliDatePicker({
                dateFormat: "YYYY-MM-DD",
                dateString: "2067-12-25"
            });
            $("#endWeekDay").nepaliDatePicker({
                dateFormat: "YYYY-MM-DD",
                dateString: "2067-12-25"
            });
            $(document).on('change', '#horoscorp_type', function () {
                // alert($(this).val());
                var horoscorp_type = $(this).val();
                checkHoroscorpType(horoscorp_type);
            })

            function checkHoroscorpType(type) {
                $('.daily_horoscope').hide();
                $('.weekly_horoscope').hide();
                $('.monthly_horoscope').hide();
                $('.yearly_horoscope').hide();

                if (type == 'daily') {
                    $('.daily_horoscope').show();
                } else if (type == 'weekly') {
                    $('.weekly_horoscope').show();
                } else if (type == 'monthly') {
                    $('.yearly_horoscope').show();
                    $('.monthly_horoscope').show();
                } else if (type == 'yearly') {
                    $('.yearly_horoscope').show();
                    // $('.monthly_horoscope').show();

                } else {
                    $('.daily_horoscope').show();
                }
            }

            checkHoroscorpType("{{ @$horoscope->type ?? 'daily'  }}");
        })

    </script>
@endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            @if (isset($horoscope))
                {{ Form::open(['url' => route('horoscope.update', $horoscope->id), 'files' => true, 'class' => 'form', 'name' => 'horoscope_form']) }}
                @method('put')
            @else
                {{ Form::open(['url' => route('horoscope.store'), 'files' => true, 'class' => 'form', 'name' => 'horoscope_form']) }}
            @endif
            <div class="row">
                <div class="col-lg-9">
                    <div class="card card-primary card-outline">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Horoscope</h3>
                                <div class="card-tools">
                                    <a href="{{ route('horoscope.index') }}" type="button" class="btn btn-tool">
                                        <i class="fa fa-list"></i></a>
                                </div>
                            </div>
                            {{-- <div class="card-header">
                                <div class="row">
                                    <div class="p-1 col-lg-2">
                                        <div class="btn-group">
                                            <a href="{{ route('horoscope.index') }}" class="btn btn-primary btn-flat btn-sm">
                                                <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-1 col-lg-7">
                                        <form action="" class="">
                                            <div class="row">
                                                <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                                    {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control', 'placeholder' => 'Search Title']) !!}
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4">
                                                    <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                                        Filter</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="p-1 col-lg-3">
                                        <div class="card-tools">
                                            @can('Horoscope-create')
                                                <a href="{{ route('horoscope.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                                    <i class="fa fa-plus"></i> Add New Horoscope</a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($columns as $column)
                                        <div class="col-lg-6">
                                            <div class="form-group{{ $errors->has($column) ? 'has-error' : '' }}">
                                                {!! Form::label($column, "  $column :  ", ['class' => 'col-sm-12 text-capitalize bold']) !!}
                                                <div class="col-sm-12">
                                                    {{ Form::textarea($column, @$horoscope->$column, ['class' => 'form-control ckeditor', 'id' => $column, 'placeholder' => $column, 'required' => true, 'style' => 'height:80px;']) }}
                                                    @error($column)
                                                    <span class="help-block error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-info   card-outline">
                        <div class="card-body">
                            <div class="form-group  {{ $errors->has('type') ? 'has-error' : '' }}">
                                {{ Form::label('type', 'Rashifal Type :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('type', $horoscope_types, @$horoscope->type, ['id' => 'horoscorp_type', 'required' => true, 'class' => 'form-control form-control-sm']) }}
                                    @error('type')
                                    <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div
                                class="form-group row daily_horoscope {{ $errors->has('published_at') ? 'has-error' : '' }}">
                                {{ Form::label('published_at', 'Publish Date :', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">

                                    {{ Form::text('published_at', @$horoscope->published_at, ['id' => 'nepali-datepicker', 'required' => false, 'class' => 'form-control form-control-sm date']) }}

                                    @error('published_at')
                                    <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row weekly_horoscope">
                                <div class="col-lg-12">
                                    <div class="form-group row {{ $errors->has('startWeekDay') ? 'has-error' : '' }}">
                                        {{ Form::label('startWeekDay', 'Week Start date :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">

                                            {{ Form::text('startWeekDay', readableDate(@$horoscope->startWeekDay, 'date')  , ['id' => 'startWeekDay', 'required' => false, 'class' => 'form-control form-control-sm date']) }}

                                            @error('startWeekDay')
                                            <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group row {{ $errors->has('endWeekDay') ? 'has-error' : '' }}">
                                        {{ Form::label('endWeekDay', 'Week End date :', ['class' => 'col-sm-12']) }}
                                        <div class="col-sm-12">

                                            {{ Form::text('endWeekDay', readableDate(@$horoscope->endWeekDay, 'date'), ['id' => 'endWeekDay', 'required' => false, 'class' => 'form-control form-control-sm date']) }}

                                            @error('endWeekDay')
                                            <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$horoscope->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control form-control-sm']) }}
                                    @error('publish_status')
                                    <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group yearly_horoscope  {{ $errors->has('year') ? 'has-error' : '' }}">
                                {{ Form::label('type', 'Select year :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('year', $years, @$horoscope->year, ['id' => 'type', 'class' => 'form-control form-control-sm']) }}
                                    @error('year')
                                    <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group monthly_horoscope  {{ $errors->has('month') ? 'has-error' : '' }}">
                                {{ Form::label('month', 'Select Month :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('month', @$months, @$horoscope->month, ['id' => 'type', 'class' => 'form-control form-control-sm']) }}
                                    @error('month')
                                    <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">

                                <div class="col-sm-12">
                                    {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-sm btn-flat', 'type' => 'submit']) }}
                                    {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'reset']) }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>
@endsection
