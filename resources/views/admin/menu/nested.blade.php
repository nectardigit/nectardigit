@foreach ($data as $item)
    <ol>
        <li id="menuItem_{{ $item->id }}">
            <div class="menu-handle d-flex justify-content-between">
                <span>
                    <i class="fa fa-arrows-alt"></i> &nbsp;
                    @if ($_website == 'Nepali' || $_website == 'Both')
                        {{ $item->title['np'] }}
                    @endif
                    @if ($_website == 'English' || $_website == 'Both')
                        {{ $item->title['en'] }}
                    @endif
                </span>
                <div class="menu-options btn-group">
                    <a href="{{ route('menu.additonal', $item->id) }}" class="btn btn-xs btn-warning }}">
                        <i class="fas fa-list"></i>
                    </a>
                    <a href="#" class="btn btn-xs btn-{{ $item->publish_status == '1' ? 'info' : 'danger' }}" title="{{ $item->publish_status ? 'Unpublish This Menu' : 'Publish This Menu' }}">
                        <i class="fa {{ $item->publish_status == '1' ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                    </a>
                    
                    <a href="{{ validate_url($item->slug) ? $item->slug : Config::get('APP_URL') . '/' . $item->slug ?? $item->slug }}"
                        target="__banner" class="btn btn-xs btn-primary"><i class="fa fa-link"></i></a>
                    @can('menu-edit')
                        <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-xs btn-success"><i
                                class="fa fa-edit"></i></a>
                    @endcan
                    @can('menu-delete')
                        {{ Form::open(['method' => 'DELETE', 'route' => ['menu.destroy', $item->id], 'class' => '', 'id' => $item->id]) }}
                        {{ Form::close() }}
                        {{ Form::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-xs btn-danger', 'type' => 'submit', 'title' => 'Delete Menu', 'onclick' => 'if(!confirm("Do you really want to delete this?")){return false}else{ document.getElementById(' . $item->id . ').submit()}']) }}
                    @endcan
                </div>
            </div>
            @include('admin.menu.nested',['data'=>$item->child_menu])
        </li>
    </ol>
@endforeach
