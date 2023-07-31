<!DOCTYPE html>
<html lang="en">
<head>
    @csrf
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title',env('APP_NAME'))</title>
    <link rel="shortcut icon" href="{{ asset('img/AdminLTELogo.png') }}" type="image/png" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/date.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toggle_button.css') }}">
    <script src="{{ asset('/assets/front/js/jquery.min.js') }}" type="text/javascript"></script>
    @stack('styles')
    @livewireStyles
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
