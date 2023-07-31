@extends('layouts.auth')
@section('title','Two Factor Authentication')
@section('content')
<div class="content">
  <div class="login-box">
    <div class="card">
      <div class="card-body rounded login-card-body">
        <form id="register-form" action="{{ url('/two-factor-challenge') }}" method="post">
          <h2 class="text-bold text-center text-lg">Enter your authentication code to login.</h2>
          @csrf
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <p class="text-sm">Enter code from your mobile authenticator app</p>
          <div class="form-group @error('code') has-error @enderror">
              <input class="form-control" type="text" name="code" placeholder="Enter Code" autocomplete="off">
              @error('code')
              <label class="help-block" for="code">{{ $message }}</label>
              @enderror
          </div>
          <div class="form-group">
              <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-paper-plane"></i> Login with code</button>
          </div>
          <p class=""><a href="{{ url('two-factor-recovery') }}" class="">Loin with recovery code</a></p>
      </form>
    </div>
    </div>
  </div>
</div>
@endsection