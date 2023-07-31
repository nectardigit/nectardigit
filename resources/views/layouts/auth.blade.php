<!DOCTYPE html>
<html>

<head>
  @csrf
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>@yield('title',env('APP_NAME'))</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/png" />
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
</head>

<body class="{{ (request()->is('user/confirm-password'))?"hold-transition lockscreen":'' }}">
    <div class="{{ (request()->is('user/confirm-password'))?"":"login" }}">
        @include('admin.section.notify')
        @yield('content')
    </div>
    <script src="{{ asset('js/manifest.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin.js') }}" type="text/javascript"></script>
    @stack('scripts')
</body>

</html>