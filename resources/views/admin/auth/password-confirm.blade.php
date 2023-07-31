@extends('layouts.auth')
@section('content')

    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="">{{ env('APP_NAME', 'MOFAGA ADMIN') }}</a>
        </div>
       
        <div class="lockscreen-name text-md">{{ @\Auth::user()->name['en'] }}</div>
        <div class="lockscreen-item">
            <div class="lockscreen-image">

                <img src="{{ @$user->has_profile->image ? asset('/uploads/profile/' . @$user->has_profile->image) : asset('img/AdminLTELogo.png') }}"
                    alt="{{ @\Auth::user()->name['en'] }}">
            </div>
            <form class="lockscreen-credentials" action="{{ url('user/confirm-password') }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="password">
                    <div class="input-group-append">
                        <button type="submit" class="btn">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="help-block text-center text-sm text-red pt-0">
            @error('password')
                <label class="help-block" for="password">{{ $message }}</label>
            @enderror
        </div>

        <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>
        <div class="lockscreen-footer text-center mt-4">
            Copyright &copy; 2019-{{ date('Y') }} <b>
                <a href="{{ route('dashboard.index') }}" class="text-black">
                    {{ strtoupper(env('APP_NAME', 'Nectar Dight')) }}
                </a>
            </b>
            <br>
            All rights reserved
        </div>
    </div>

@endsection
