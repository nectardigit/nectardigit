@include('website.index.notice')
@extends('layouts.front')
@section('page_title', 'Nectar Digit')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection

@section('content')
    @include('website.index.banner')
    @include('website.index.client')
    @include('website.index.services')
    @include('website.index.benefit')
    <section class="blog mt">
        @include('website.index.blog')
    </section>
    @include('website.index.counter')
    @include('website.index.faq')
    @include('website.index.video')
    @include('website.index.newsletter')
@endsection
@push('scripts')

@endpush
