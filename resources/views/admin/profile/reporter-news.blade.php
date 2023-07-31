@extends('layouts.admin')
@section('title', 'Reporter List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ create_image_url(@$news_user->profile_image_url) }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ @$news_user->name[$_locale] }}</h3>

                            <p class="text-muted text-center">{!! @$news_user->designation !!}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total News</b> <a class="float-right"> {{ @$news_users_news->total() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Published News</b> <a class="float-right">{{ $news_user->published_news }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Unpublished News</b> <a class="float-right">{{ $news_user->unpublished_news }}</a>
                                </li>
                            </ul>

                            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    {{-- <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>

                            <p class="text-muted">
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                            <p class="text-muted">Malibu, California</p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                        </div>
                        <!-- /.card-body -->
                    </div> --}}
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#news" data-toggle="tab">News</a></li>
                                {{-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li> --}}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="news">
                                    <div style="overflow-x: scroll" class="card-body card-format">
                                        <table class="table table-striped table-hover"> {{-- table-bordered --}}
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th> Title  </th>
                                                    <th> Thumbnail </th>
                                                    <th> Categories </th>
                                                    <th> Tags </th>
                                                    <th>Views</th>
                                                    <th> Status </th>
                                                    <th style="text-align:center;" width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                
                                                @foreach ($news_users_news as $key => $value)
                
                                                    <tr>
                                                        <td>{{ $key + 1 }}.</td>
                                                        <td>{{ @$value->title['np'] }}</td>
                                                        <td>
                                                            <a target="_blank"
                                                                href="{{ create_image_url($value->img_url,'thumbnail') }}">
                                                                <img src="{{ create_image_url($value->img_url, 'thumbnail') }}"
                                                                    alt="{{ @$value->title['en'] }}" class="img img-thumbail"
                                                                    style="width:60px">
                                                            </a>
                                                        </td>
                
                                                        <td>
                                                           
                                                            @if ($value->newsHasCategories)
                                                                @foreach ($value->newsHasCategories as $key => $catItem)
                                                                    <span
                                                                        class="badge badge-success">{{ @$catItem->title[$_locale] }}</span>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        
                
                                                        <td>
                                                            @if ($value->newsHasTags)
                                                                @foreach ($value->newsHasTags as $key => $tagItem)
                                                                    <span class="badge badge-info">{{ @get_title(@$tagItem) }}
                                                                    </span>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info">{{ $value->view_count }}</span>
                                                        </td>
                                                        
                
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $value->publish_status == '1' ? 'success' : 'danger' }}">
                                                                {{ $value->publish_status == '1' ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('newsDetail', $value->slug) }}"
                                                                    title="Edit News" class="btn btn-primary btn-sm btn-flat" target="_blank">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                @canany('news-edit','newsenglish-update','newsnepali-update')
                                                                @if (@$value->news_language == 'en')
                                                                    <a href="{{ route('editNewsInEnglish', $value->id) }}"
                                                                        title="Edit News" class="btn btn-success btn-sm btn-flat">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('editNewsInNepali', $value->id) }}"
                                                                        title="Edit News" class="btn btn-success btn-sm btn-flat">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                @endcanany
                                                                @can('news-delete')
                                                                    {{ Form::open(['method' => 'DELETE', 'route' => ['news.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this News?")']) }}
                                                                    {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete News ']) }}
                                                                    {{ Form::close() }}
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                
                                        <div class="mt-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-sm">
                                                        Showing <strong>{{ $news_users_news->firstItem() }}</strong> to
                                                        <strong>{{ $news_users_news->lastItem() }} </strong> of <strong>
                                                            {{ $news_users_news->total() }}</strong>
                                                        entries
                                                        <span> | Takes <b>{{ round(microtime(true) - LARAVEL_START, 2) }}</b> seconds to
                                                            render</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-8">
                                                    <span class="pagination-sm m-0 float-right">{{ $news_users_news->links() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
 
@endsection
