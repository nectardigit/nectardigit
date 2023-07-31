@extends('layouts.admin')
@section('title', 'Admin Dashboard')
    @push('scripts')


        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


    @endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">



                @if (in_array($userRole, admin()))

                    @if (in_array('user', $app_content))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ @$count_data['user'] }}</h3>
                                    <p>Total Users</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                @canany(['user-list'])
                                    <a href="{{ route('users.index') }}" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endcanany

                            </div>
                        </div>
                    @endif
                @endif

                @if (in_array($userRole, admin()))
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ @$count_data['admin'] }}</h3>
                                <p>Admins</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            @canany(['user-list'])
                                <a href="{{ route('users.index', ['type' => 'admin']) }}" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            @endcanany

                        </div>
                    </div>
                @endif





                @if (in_array($userRole, admin()))
                    @if (in_array('slider', $app_content))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="small-box bg-navy">
                                <div class="inner">
                                    <h3>{{ @$count_data['totalslider'] }}</h3>
                                    <p>Total Sliders</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                @canany(['slider-list'])
                                    <a href="{{ route('slider.index') }}" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endcanany
                            </div>
                        </div>
                    @endif
                @endif

                @if (in_array($userRole, admin()))
                    @if (in_array('slider', $app_content))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="small-box bg-defult">
                                <div class="inner">
                                    <h3>{{ @$count_data['published_slider'] }}</h3>
                                    <p>Total Published Sliders </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                @canany(['slider-list'])
                                    <a href="{{ route('slider.index', ['status' => '1']) }}" class="small-box-footer">More
                                        info
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endcanany
                            </div>
                        </div>
                    @endif
                    @if (in_array('slider', $app_content))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ @$count_data['unpublished_slider'] }}</h3>
                                    <p>Total Unublished Sliders </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                @canany(['slider-list'])
                                    <a href="{{ route('slider.index', ['status' => '0']) }}" class="small-box-footer">More
                                        info
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endcanany
                            </div>
                        </div>
                    @endif
                @endif


                @if (in_array('blogs', $app_content))
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="small-box bg-default">
                            <div class="inner">
                                <h3>{{ @$count_data['totalblog'] }}</h3>
                                <p>Total Blogs </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                            @canany(['blog-list'])
                                <a href="{{ route('blog.index') }}" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            @endcanany
                        </div>
                    </div>
                @endif
                @if (in_array('blogs', $app_content))
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ @$count_data['published_blog'] }}</h3>
                                <p>Total Published Blogs </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                            @canany(['blog-list'])
                                <a href="{{ route('blog.index', ['status' => '1']) }}" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            @endcanany
                        </div>
                    </div>
                @endif

                @if (in_array('blogs', $app_content))
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="small-box bg-black">
                            <div class="inner">
                                <h3>{{ @$count_data['unpublished_blog'] }}</h3>
                                <p>Total Unpublished Blogs </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                            @canany(['blog-list'])
                                <a href="{{ route('blog.index', ['status' => '0']) }}" class="small-box-footer">More info
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            @endcanany
                        </div>
                    </div>
                @endif
                @if (in_array($userRole, admin()))
                    @if (in_array('testimonial', $app_content))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="small-box bg-default">
                                <div class="inner">
                                    <h3>{{ @$count_data['totaltestimonial'] }}</h3>
                                    <p>Total Testimonial </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                @canany(['testimonial-list'])
                                    <a href="{{ route('testimonial.index') }}" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endcanany
                            </div>
                        </div>
                    @endif
                    @if (in_array('testimonial', $app_content))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ @$count_data['published_testimonial'] }}</h3>
                                    <p>Total Published Testimonial </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                @canany(['testimonial-list'])
                                    <a href="{{ route('testimonial.index', ['status' => '1']) }}"
                                        class="small-box-footer">More
                                        info
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endcanany
                            </div>
                        </div>
                    @endif
                    @if (in_array('testimonial', $app_content))
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ @$count_data['unpublished_testimonial'] }}</h3>
                                    <p>Total Unpublished Testimonial </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                @canany(['testimonial-list'])
                                    <a href="{{ route('testimonial.index', ['status' => '0']) }}"
                                        class="small-box-footer">More
                                        info
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endcanany
                            </div>
                        </div>
                    @endif
                @endif




                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ @$count_data['totalteam'] }}</h3>
                                            <p>Total Team </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-list"></i>
                                        </div>
                                        <a href="{{route('team.index')}}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3>{{ @$count_data['published_team'] }}</h3>
                                            <p>Total Active Team </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-list"></i>
                                        </div>
                                        <a href="{{route('team.index',['status'=>'1'])}}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>{{ @$count_data['unpublished_team'] }}</h3>
                                            <p>Total Inactive Team </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-list"></i>
                                        </div>
                                        <a href="{{route('team.index',['status'=>'0'])}}" class="small-box-footer">More info
                                            <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

            </div>

            @if (in_array($userRole, admin()))
                <!-- Start Chart content -->
                {{-- <div class="card">
                    <div class="row" style="margin-bottom: 50px;">
                        <div class="col-md-6">
                            <div class="card-header" style="background-color: #374f65;">
                                <h3 class="card-title" style="color: azure;">Viewers</h3>
                            </div>
                            <div class="card-body card-format">
                                <canvas id="all-riding-request" height="280" width="600"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-header" style="background-color: #374f65;">
                                <h3 class="card-title" style="color: azure;">Total News</h3>
                            </div>
                            <div class="card-body card-format">
                                <canvas id="hourly-complete-riding" height="280" width="600"></canvas>
                            </div>
                        </div>
                    </div>
                </div> --}}
            @endif

        </div>
    </div>
@endsection
