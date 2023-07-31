@extends('layouts.auth')
@section('title',  'Admin Login')
@section('content')
    <div class="contents">
        <form id="login-form" action="{{ route('login') }}" method="post">
            @csrf
            <div class="d-flex justify-content-center">
                <a href="" class=""><img src="{{ asset('img/AdminLTELogo.png') }}" class="img-fluid" alt=""></a>
            </div>
            <h2 class="login-title">Admin Login</h2>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text  @error('email') is-warning  @enderror">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <input class="form-control  @error('email') is-invalid @enderror" type="text" name="email"
                        placeholder="Email or Mobile" value="{{ old('email') }}" autofocus autocomplete="off">
                </div>
                @error('email')
                    <span class="error" for="email">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text @error('password') is-warning @enderror">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                        placeholder="Password" value="{{ old('password') }}" autocomplete="off">
                </div>
                @error('password')
                    <span class="error" for="password">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group d-flex justify-content-between">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="remember" type="checkbox" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="custom-control-label font-weight-normal">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block btn-flat" type="submit"> <i class="fa fa-sign-in-alt"></i> Login</button>
            </div>

            @if (Route::has('register'))
            <div class="text-center">Don't have a account?
                <a class="color-blue" href="{{ route('register') }}">Register here</a>
            </div>
            @endif
        </form>
    </div>
@endsection
