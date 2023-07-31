@extends('layouts.auth')
@section('title','Verify Email')
@section('content')
<div class="contents">
  <h2 class="text-center pt-2 text-lg text-bold">You Must Verify Your Email</h2>
  <form id="login-form" action="{{ route('verification.send') }}" method="post">
      @csrf
      @if (!session('status'))
      <p class="text-sm">You must verify your email address to login, please check your email for a verification link.</p>
      @else
      <blockquote class="quote-danger">
        <p>Verification link is sent please check your email.</p>
      </blockquote>
      @endif
      <div class="form-group">
          <button class="btn btn-primary btn-block btn-flat" type="submit"><i class="fas fa-paper-plane"></i> Resend email</button>
      </div>
      <div class="text-center">Login now?
        @if (Route::has('login'))
        <a class="color-blue" href="{{ route('login') }}"> Login</a>
        @endif
      </div>
  </form>
</div>
@endsection