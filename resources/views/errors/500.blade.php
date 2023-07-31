@extends('layouts.front')
@section('page_title', '500')
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
            <h1>500</h1>
            <h3>Oops! Internal Server Error</h3>
            <p>The server encountered an unexpected condition.</p>
            <a href="{{ url('/') }}" class="btn1 btn-with-image orange-gradient">
                Return To Homepage
            </a>
        </div>
    </div>
</div>

@endsection
@push('scripts')
@endpush
