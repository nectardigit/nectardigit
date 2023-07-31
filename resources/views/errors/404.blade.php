@extends('layouts.front')
@section('page_title', '404')
@push('styles')
<style>
    .error-page-section{
        margin:60px 0px;
    }
</style>
@endpush

@section('content')

<div class="error-page-section">
    <div class="container">
        <div class="error-page-inner">
            <h1>404</h1>
            <h3>Oops! Page Not Found</h3>
            <p>The page you were looking for could not be found.</p>
            <a href="{{ url('/') }}" class="btn1 btn-with-image orange-gradient">
                Return To Homepage
            </a>
        </div>
    </div>
</div>

@endsection
@push('scripts')
@endpush
