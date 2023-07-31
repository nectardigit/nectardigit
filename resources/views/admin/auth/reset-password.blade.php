@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
<div class="login-box">
  <div class="login-logo">
    <h4 href="">Reset Password</h4>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg text-md px-0">You are only one step a way from your new password, recover your password now.</p>

      <form id="register-form" action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="input-group mb-3">
          <input type="email" class="form-control"name="email" value="{{ $request->email }}" placeholder="Email" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
          <span class="error" for="email">{{ $message }}</span>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input class="form-control" id="password" type="password" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
          <span class="error" for="password">{{ $message }}</span>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password_confirmation')
          <span class="error" for="password_confirmation">{{ $message }}</span>
          @enderror
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fas fa-paper-plane"></i> Change password</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-1 float-right">
        <a href="{{ route('login') }}">Login</a>
      </p>
    </div>
  </div>
</div>
@endsection