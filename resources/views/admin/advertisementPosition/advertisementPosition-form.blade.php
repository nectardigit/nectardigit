@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        {{-- <script src="{{ asset('/custom/advertisementposition.js') }}"></script> --}}
        <script>
            $(document).ready(function() {
                $('#section').select2({
                    placeholder: "Advertisement section",
                    allowClear :true
                });
                $('#ad_position_type').select2({
                    placeholder: "Advertisement Position Type"
                })
                $('#advertisement_pages').select2({
                    placeholder: "Advertisement Position Type"
                })
                $('#ad_position_type').on('change', function() {
                    var value = $(this).val();
                    swithcPositionType(value);
                })
                $("#advertisement_pages").on('change', function(){
                    var value = $(this).val();
                    swithcPositionType(value);
                })
                swithcPositionType("{{ @$advertisementposition_info->page ?? 'all' }}");
                

                function swithcPositionType(shared) {
                    if (shared == 'homepage') {
                        $('.is_homepage').show();
                    } else {
                        $('.is_homepage').hide();
                    }
                }
            });

        </script>
    @endpush
@section('content')
    
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('advertisementposition.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($advertisementposition_info))
                        {{ Form::open(['url' => route('advertisementposition.update', $advertisementposition_info->id), 'files' => true, 'class' => 'form', 'name' => 'advertisementposition_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('advertisementposition.store'), 'files' => true, 'class' => 'form', 'name' => 'advertisementposition_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                        <div class="col-sm-10 offset-lg-1">
                            {{-- <div class="form-group row {{ $errors->has('ad_position_type') ? 'has-error' : '' }}">
                                {{ Form::label('ad_position_type', 'Advertisement Position Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('ad_position_type', $ad_position_types, @$advertisementposition_info->ad_position_type, ['class' => 'form-control', 'id' => 'ad_position_type', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('ad_position_type')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group row not_shared {{ $errors->has('page') ? 'has-error' : '' }}">
                                {{ Form::label('page', 'Page :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('page', $pages, @$advertisementposition_info->page, ['class' => 'form-control', 'id' => 'advertisement_pages',   'required' => true, 'style' => 'width:80%']) }}
                                    @error('page')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror 
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Advertisement Position Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$advertisementposition_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Advertisement Position Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row {{ $errors->has('key') ? 'has-error' : '' }}">
                                {{ Form::label('key', 'Key :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('key', @$advertisementposition_info->key, ['class' => 'form-control', 'id' => 'key', 'placeholder' => 'Advertisement Position Key', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('key')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                {{ Form::label('quantity', 'Number of Position :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('quantity', @$advertisementposition_info->quantity, ['class' => 'form-control', 'id' => 'qunatity', 'placeholder' => 'Number of Advertisement Position', 'style' => 'width:80%', 'min' => '1']) }}
                                    @error('quantity')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group is_homepage row {{ $errors->has('section') ? 'has-error' : '' }}">
                                {{ Form::label('section', 'Section :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('section', @$section, @$advertisementposition_info->section, ['class' => 'form-control  ', 'id' => 'section', 'multiple' => false, 'placeholder' => "Advertisement Section", 'style' => 'width:80%']) }}
                                    @error('section')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$advertisementposition_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
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
