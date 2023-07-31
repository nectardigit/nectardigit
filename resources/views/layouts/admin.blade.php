    @include('admin.section.header')
   
    @include('admin.section.top-nav')
    @include('admin.section.sidebar')
        <div class="content-wrapper">
            @include('admin.section.notify')
            @yield('content')
        </div>
    @include('admin.section.copy')
    @include('admin.section.footer')
