@extends('layouts.auth')
@section('title','Two Factor Authentication Recovery')
@section('content')
<div class="content">
  <div class="login-box">
    <div class="card">
      <div class="card-body rounded login-card-body">
        <form id="register-form" action="{{ url('/two-factor-challenge') }}" method="post">
          <h2 class="text-bold text-center mb-3" style="font-size:22px;">Enter your recovery code to login.</h2>
          @csrf
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <p class="text-sm">Enter recovery code which you was store.</p>
          <div class="form-group @error('code') has-error @enderror">
            <input class="form-control" type="text" name="recovery_code" placeholder="Enter Recovery Code" autocomplete="off">
            @error('recovery_code')
            <label class="help-block" for="recovery_code">{{ $message }}</label>
            @enderror
          </div>
          <div class="form-group">
              <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-paper-plane"></i> Login with recovery code</button>
          </div>
          <p class=""><a href="{{ url('two-factor-challenge') }}" class="">Login with code</a></p>
      </form>
    </div>
    </div>
  </div>
</div>
@endsection