@extends('layouts.admin')
@section('title', $title)
@push('scripts')
        @include('admin.section.ckeditor')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

        <script>
            $(document).ready(function() {
            $('#filepath_app_button').filemanager('image');
            $('#main_image').filemanager('image');

                $('#filepath_app').change(function() {
                    // alert('hello');
                    var input = this;
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $('#filepath_app_view').attr('src', e.target.result).fadeIn(1000);
                            $('#filepath_app_view').removeClass('d-none');
                            // $('#img_edit').addClass('d-none');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                })
            })

        </script>

        @livewireScripts
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        {{-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> --}}
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
                $('#advertisement_pages').select2({
                    placeholder: "Advertisement page"
                })

                $("#advertisement_pages").on('change', function() {
                    var value = $(this).val();
                    swithcPositionType(value);
                    fetchAdposition(value);
                })
                swithcPositionType("{{ @$advertisement_info->page ?? 'all' }}");
                var page =  $("#advertisement_pages").val();
               var position = "{{ @$advertisement_info->position ?? null}}";
                fetchAdposition(page, position);
                function fetchAdposition(value, position){
                $.ajax({
                        method: 'get',
                        url: "{{ route('getAdpositions') }}",
                        data: {
                            page: value,
                            position : position
                        },
                        success: function(response) {
                            if (response.status) {
                                console.log(response);
                                $('.replace_html').html(response.html);
                                $('#position').select2({
                                    placeholder: "Advertisement Position"
                                })
                            }
                        }
                    })
            }
                function swithcPositionType(shared) {
                // if (shared == 'homepage') {
                //     $('.is_homepage').show();
                // } else {
                //     $('.is_homepage').hide();
                // }

            }
            });
            $(function() {
                $("#datepicker1").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });

            $(document).ready(function() {
                $('#show_on').select2({
                    placeholder: "Show on",
                });
            });
            $(document).ready(function() {
                $('#direction').select2({
                    placeholder: "Advertisement Direction",
                });

            });



            // function siwtchPositionType(is_shared) {

            //     if (is_shared == "YES") {
            //         $("div.not_shared").hide();
            //         $('div.has_shared').show();
            //         $("div.not_shared select ").val('');
            //         $('#page_name').val('');
            //     }
            //     if (is_shared == "NO") {
            //         $("div.not_shared").show();
            //         $('div.has_shared').hide();
            //         $("div.has_shared select ").val('');
            //         $('#page_name').val('');
            //     }
            // }

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
                        <a href="{{ route('information.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($advertisement_info))
                        {{ Form::open(['url' => route('advertisement.update', $advertisement_info->id), 'files' => true, 'class' => 'form', 'name' => 'advertisement_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('advertisement.store'), 'files' => true, 'class' => 'form', 'name' => 'advertisement_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}

                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="form-group row not_shared {{ $errors->has('page') ? 'has-error' : '' }}">
                                {{ Form::label('page', 'Advertisement Page :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('page', $pages, @$advertisement_info->page, ['class' => 'form-control', 'id' => 'advertisement_pages', "placeholder" => "Advertisement Page", 'required' => true, 'style' => 'width:80%']) }}
                                    @error('page')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row replace_html {{ $errors->has('position') ? 'has-error' : '' }}">

                            </div>
                            {{-- <div class="form-group is_homepage row {{ $errors->has('section') ? 'has-error' : '' }}">
                                {{ Form::label('section', 'Section :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('section', @$section, @$advertisement_info->section, ['class' => 'form-control  ', 'id' => 'section', 'multiple' => false, 'placeholder' => "Advertisement Section", 'style' => 'width:80%']) }}
                                    @error('section')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Advertisement Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$advertisement_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Advertisement Title', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('organization') ? 'has-error' : '' }}">
                                {{ Form::label('organization', 'Organization :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('organization', @$advertisement_info->organization, ['class' => 'form-control', 'id' => 'organization', 'placeholder' => 'Advertisement organization', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('organization')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('url') ? 'has-error' : '' }}">
                                {{ Form::label('url', 'URL :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::url('url', @$advertisement_info->url, ['class' => 'form-control', 'id' => 'url', 'placeholder' => 'Advertisement URL', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('url')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            {{-- <div class="form-group row not_shared   {{ $errors->has('position') ? 'has-error' : '' }}" >
                                {{ Form::label('position', 'Position :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('columnType', $specificPosition, @$advertisement_info->columnType, ['class' => 'form-control  ', 'id' => 'columnType',   'style' => 'width:80%', 'placeholder' => 'Advertisement Position']) }}
                                    @error('columnType')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row {{ $errors->has('columnType') ? 'has-error' : '' }}">
                                {{ Form::label('columnType', 'Column Type :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('columnType', COLUMN_TYPE, @$advertisement_info->columnType, ['class' => 'form-control  ', 'id' => 'columnType', 'required' => true, 'style' => 'width:80%', 'placeholder' => 'Column Type']) }}
                                    @error('columnType')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('direction') ? 'has-error' : '' }}">
                                {{ Form::label('direction', 'Advertisement Direction :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('direction', DIRECTION, @$advertisement_info->direction, ['class' => 'form-control  ', 'id' => 'direction', 'required' => true, 'style' => 'width:80%', 'placeholder' => 'Advertisement Direction']) }}
                                    @error('direction')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('show_on') ? 'has-error' : '' }}">
                                {{ Form::label('show_on', 'Show on :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">

                                    {{ Form::select('show_on', @$show_on, @$advertisement_info->show_on, ['class' => 'form-control  ', 'id' => 'show_on', 'required' => true, 'style' => 'width:80%', 'placeholder' => 'Show on']) }}
                                    @error('show_on')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row {{ $errors->has('from_date') ? 'has-error' : '' }}">
                                {{ Form::label('from_date', 'from_date :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('from_date', @$advertisement_info->from_date, ['class' => 'form-control date', 'id' => 'datepicker', 'placeholder' => 'Click here', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('from_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="form-group row {{ $errors->has('to_date') ? 'has-error' : '' }}">
                                {{ Form::label('to_date', 'to_date :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('to_date', @$advertisement_info->to_date, ['class' => 'form-control date', 'id' => 'datepicker1', 'placeholder' => 'Click here', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('to_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group row">
                                {{ Form::label('filepath', 'Advertisement Image for all screen:*', ['class' => 'col-sm-12']) }}

                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="main_image" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="all_screen_image_url"
                                        value="{{ @$advertisement_info->img_url }}">
                                </div>
                                <div id="holder" style="margin-top:15px;max-width: 100%;">
                                    <img src="{{ @$advertisement_info->img_url }}" alt=""
                                        style="max-width: 100%">
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('filepath_app', 'Image for Mobile screen (optional):', ['class' => 'col-sm-12']) }}
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="filepath_app_button" data-input="filepath_app" data-preview="filepath_app_holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="filepath_app" class="form-control" type="text" name="mobile_screen_image_url"
                                        value="{{ @$advertisement_info->img_url_app }}">
                                </div>
                                <div id="filepath_app_holder" style="margin-top:15px;max-width: 100%;">
                                    <img src="{{ @$advertisement_info->img_url_app }}" alt="" style="max-width: 100%">
                                </div>
                            </div>
                            @can('advertisement-publish')
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$advertisement_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:90%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endcan
                            <div class="form-group row">
                                {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-12">
                                    {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-flat', 'type' => 'submit']) }}
                                    {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-danger btn-flat', 'type' => 'reset']) }}
                                </div>
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


