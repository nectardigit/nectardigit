@extends('layouts.auth')
@section('title', 'Forget Password')
@push('scripts')
<script>
  setTimeout(function(){
      $('.alert').slideUp();
  },8000);
</script>
@endpush
@section('content')
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body rounded">
      <div class="login-logo pt-2">
        <h4 href="">Forgot Password</h4>
      </div>
      @if (!session('status'))
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      @else
      <blockquote class="quote-primary">
        <p>{{ session('status') }}</p>
      </blockquote>
      @endif
      <form id="register-form" action="{{ route('password.request') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
          <span class="error" for="email">{{ $message }}</span>
          @enderror
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-paper-plane"></i> Request new password</button>
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