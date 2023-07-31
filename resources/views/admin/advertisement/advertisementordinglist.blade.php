@extends('layouts.admin')
@section('title', 'Order of Advertisement')
    @push('scripts')
        <script src="{{ asset('plugins/sortablejs/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('plugins/sortablejs/jquery.mjs.nestedSortable.js') }}"></script>
        <script src="{{ asset('plugins/toastrjs/toastr.min.js') }}"></script>
        <script>
            $('ol.sortable').nestedSortable({
                forcePlaceholderSize: true,
                placeholder: 'placeholder',
                handle: 'div.menu-handle',
                helper: 'clone',
                items: 'li',
                opacity: .6,
                maxLevels: {{ env('MENU_LEVEL', 3) }},
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> div',
            });
            $("#serialize").click(function(e) {
                e.preventDefault();
                $(this).prop("disabled", true);
                $(this).html(
                    `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    );
                var serialized = $('ol.sortable').nestedSortable('serialize');
                //console.log(serialized);
                $.ajax({
                    url: "{{ route('advertisement.updae.order') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        sort: serialized
                    },
                    success: function(repsonse) {
                        //location.reload();
                        toastr.options.closeButton = true
                    if(repsonse.status){
                        toastr.success(repsonse.message, "Success !");
                    }else {
                        toastr.success(repsonse.message, "Error !");

                    }
                        $('#serialize').prop("disabled", false);
                        $('#serialize').html(`<i class="fa fa-save"></i> Update Menu`);
                    }
                });
            });

            function show_alert() {
                if (!confirm("Do you really want to do this?")) {
                    return false;
                }
                this.form.submit();
            }

        </script>
    @endpush
    @push('styles')
        <style>
            ol {
                list-style-type: none;
            }

            .menu-handle {
                display: block;
                margin-bottom: 5px;
                padding: 6px 4px 6px 12px;
                color: #333;
                font-weight: bold;
                border: 1px solid #ccc;
                background: #fafafa;
                background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
                background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
                background: linear-gradient(top, #fafafa 0%, #eee 100%);
                -webkit-border-radius: 3px;
                border-radius: 3px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                cursor: move;
            }

            .menu-handle:hover {
                color: #2ea8e5;
                background: #fff;
            }

            .placeholder {
                outline: 1px dashed #4183C4;
                margin-bottom: 10px;
                background: #D7F8FD
            }

        </style>
    @endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order of Advertisement</h3>
                    <!-- <div class="card-tools">
                        <a href="{{ route('menu.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div> -->
                </div>
                <div class="card-header">
                    <div class="btn-group">
                        <a href="{{ route('advertisement.ordering',$advertisementid) }}" class="btn btn-primary btn-flat btn-sm">
                            <i class="fas fa-sync-alt fa-sm"></i> Refresh
                        </a>
                    </div>
                    <!-- <div class="card-tools">
                        @can('menu-create')
                            <a href="{{ route('menu.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                <i class="fa fa-plus"></i> Add New Menu</a>
                        @endcan
                    </div> -->
                </div>
                <div class="card-body card-format">
                    @if ($data->count() > 0)
                        <ol class="sortable">
                            @foreach ($data as $item)
                                @if ($item->parent_id == null)
                                    <li id="menuItem_{{ $item->id }}">
                                        <div class="menu-handle d-flex justify-content-between">
                                            <span>
                                                <i class="fa fa-arrows-alt"></i> &nbsp;

                                                    {{ $item->title }}

                                            </span>
                                            <!-- <div class="menu-options btn-group">
                                                <a href="{{ route('menu.additonal', $item->id) }}"
                                                    class="btn btn-xs btn-warning }}">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                                <a href="#" class="btn btn-xs btn-{{ $item->publish_status == '1' ? 'info' : 'danger' }}" title="{{ $item->publish_status ? 'Unpublish This Menu' : 'Publish This Menu' }}">
                                                    <i class="fa {{ $item->publish_status == '1' ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                </a>
                                                <a href="{{ validate_url($item->slug) ? $item->slug : Config::get('APP_URL') . '/' . $item->slug ?? $item->slug }}"
                                                    target="__banner" class="btn btn-xs btn-primary">
                                                    <i class="fa fa-link"></i>
                                                </a>

                                                @can('menu-edit')
                                                    <a href="{{ route('menu.edit', $item->id) }}"
                                                        class="btn btn-xs btn-success">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('menu-delete')
                                                    {{ Form::open(['method' => 'DELETE', 'route' => ['menu.destroy', $item->id], 'class' => 'display:hidden', 'id' => $item->id, 'onsubmit' => 'return confirm("Are you sure you want to delete this User?")']) }}
                                                    {{ Form::close() }}
                                                    {{ Form::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-xs btn-danger', 'type' => 'submit', 'title' => 'Delete Menu', 'onclick' => 'if(!confirm("Do you really want to delete this?")){return false}else{ document.getElementById(' . $item->id . ').submit()}']) }}
                                                @endcan
                                            </div> -->
                                        </div>


                                    </li>
                                @endif
                            @endforeach
                            <div class="form-group mt-4">
                                @canany(['menu-create','menu-edit'])
                                <button type="button" class="btn btn-success btn-sm btn-flat" id="serialize"><i
                                        class="fa fa-save"></i>
                                    Update Order
                                </button>
                                @endcanany

                                <a href="{{ route('advertisements.original.order')}}" type="button"
                                    class="btn btn-danger btn-sm btn-flat"><i class="fas fa-sync-alt"></i> Reset Order</a>
                            </div>
                        </ol>
                    @else
                        <p class="text-center">Menu Not Found in Database</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
