@extends('layouts.admin')
@section('title', $title )
    @push('scripts')
    <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
    <script src="{{ asset('/custom/appnotice.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#image').change( function(){
            // alert('hello');
            var  input = this;
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_view').attr('src', e.target.result).fadeIn(1000);
                    $('#image_view').removeClass('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        })
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
                        <a href="{{ route('appnotice.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($appnotice_info))
                        {{ Form::open(['url' => route('appnotice.update', $appnotice_info->id), 'files' => true, 'class' => 'form', 'name' => 'appnotice_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('appnotice.store'), 'files' => true, 'class' => 'form', 'name' => 'appnotice_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$appnotice_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'App Notice Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Description :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$appnotice_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'placeholder' => 'appnotice Description', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('url') ? 'has-error' : '' }}">
                                {{ Form::label('url', 'App Notice Link / Url :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('url', @$appnotice_info->url, ['class' => 'form-control', 'id' => 'url', 'placeholder' => 'App Notice Link / Url', 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('from_date') ? 'has-error' : '' }}">
                                {{ Form::label('from_date', 'Start Date :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('from_date', @$appnotice_info->from_date, ['class' => 'form-control', 'id' => 'from_date', 'placeholder' => 'Start Date', 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('to_date') ? 'has-error' : '' }}">
                                {{ Form::label('to_date', 'End Date :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('to_date', @$appnotice_info->to_date, ['class' => 'form-control', 'id' => 'to_date', 'placeholder' => 'End Date', 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('from_time') ? 'has-error' : '' }}">
                                {{ Form::label('from_time', 'Start Time :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::time('from_time', @$appnotice_info->from_time, ['class' => 'form-control', 'id' => 'from_time', 'placeholder' => 'Start Time', 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('to_time') ? 'has-error' : '' }}">
                                {{ Form::label('to_time', 'End Time :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::time('to_time', @$appnotice_info->to_time, ['class' => 'form-control', 'id' => 'to_time', 'placeholder' => 'End Time', 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$appnotice_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'App Notice Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::file('image',  ['id' => 'image',   'class' => '', 'style' => 'width:80%', 'accept' => 'image/*']) }}
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                    <div class="col-sm-4">
                                        <img id="image_view" src="#" alt="image" class="d-none img-fluid img-thumbnail" style="height: 80px" />
                                        {{--dd($documents_detail)--}}
                                      @if(isset($appnotice_info->image))
                                          @if(file_exists(public_path().'/uploads/appnotices/'.@$appnotice_info->image))
                                              <img src="{{asset('/uploads/appnotices/'.@$appnotice_info->image)}}" alt="{{$appnotice_info->image}}" class="img img-fluid img-thumbnail" style="height:80px" id=" ">
                                          @endif
                                      @endif
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
