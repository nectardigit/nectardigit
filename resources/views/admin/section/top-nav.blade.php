        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
           
            {{-- {{ dd($notification) }} --}}
            <ul class="navbar-nav ml-auto">
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge"><span class="update_notification">6</span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header"> <span class="update_notification">5</span> Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#">
                        <div class="m-3">
                           
                        </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href=" " class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}" target="_banner" role="button">
                        <i class="fas fa-globe-asia"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link pl-0" data-toggle="dropdown" href="#">
                        <span>{{ @\Auth::user()->name['en'] }} <i class="fas fa-angle-down fa-xs pl-1"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <a href="{{ route('profiledetail') }}" class="dropdown-item pl-3 href=" class="">
                            <i class=" fas fa-user pr-1"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('setting.index') }}" class="dropdown-item pl-3" type="button"> <i class="fas fa-cog pr-1"></i>Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item pl-3" href="{{ route('user.logout') }}" title="Logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="fa fa-power-off pr-1"></i> Logout</a>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

                </li>
            </ul>
        </nav>
