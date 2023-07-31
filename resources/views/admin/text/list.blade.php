@extends('layouts.admin')
@section('title', 'texts')
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
    <script src="{{ asset('/custom/slider.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
@section('content')
    @include('admin.shared.image_upload')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Texts List</h3>
                    <div class="card-tools">
                        <a href="{{ route('text.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                {{ Form::open(['url' => route('text.update'), 'files' => true, 'role' => 'form']) }}
                @csrf
                <div class="card-body">
                    <div class="form-group row {{ $errors->has('sliderTitle') ? 'has-error' : '' }}">
                        {{ Form::label('sliderTitle', 'Slider Title :*', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::text('sliderTitle', config('texts.sliderTitle'), ['class' => 'form-control', 'id' => 'sliderTitle', 'placeholder' => 'Slider title', 'required' => true, 'style' => 'width:80%']) }}
                            @error('sliderTitle')
                                <span class="help-block error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('sliderDescription') ? 'has-error' : '' }}">
                        {{ Form::label('sliderDescription', 'Slider Description :*', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::textarea('sliderDescription', config('texts.sliderDescription'), ['class' => 'form-control', 'id' => 'sliderDescription', 'placeholder' => 'Slider description', 'required' => true, 'style' => 'width:80%']) }}
                            @error('sliderDescription')
                                <span class="help-block error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('faqImage') ? 'has-error' : '' }}">
                        {{ Form::label('faqImage', 'Faq Image:*', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="image" data-preview="holder" class="btn btn-primary">
                                        Choose
                                    </a>
                                </span>
                                <input id="image" height="100px" class="form-control" type="text" name="faqImage">
                            </div>
                            <div id="holder" style="border-radius: 4px;
                            padding: 5px;
                            width: 150px;
                            margin-top:15px;"></div>
                            @if (config('texts.faqImage'))
                                Old Image: &nbsp; <img src="{{ config('texts.faqImage') }}" alt="Couldn't load image"
                                    class="img img-thumbail mt-2" style="width: 100px">
                            @endif
                            @error('image')
                                <span class="help-block error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-dark">Reset</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
