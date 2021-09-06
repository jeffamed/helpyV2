@extends('layouts.master')
@section('title', __('lang.reset_password'))

@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/auth.css') }}">
@endsection

@section('content')

<!-- particles.js container -->
<div id="particles-js"></div>

<!-- Forgot Password container -->
<div class="background-image pt-5 pb-13rem">
    <div class="container">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <!-- Icon -->
                <div class="fadeIn first py-3">
                    <h5>{{ __('lang.reset_password') }}</h5>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('passwordReset') }}">
                    @csrf
                    <input type="email" id="login" class="fadeIn second {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.email') }}" required>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    <input type="submit" class="fadeIn third" value="{{ __('lang.send_password_reset_link') }}">
                </form>
                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <div>
                        {{ __('lang.back_to') }}
                        <a href="{{ route('login') }}" class="bluish-text">{{ __('lang.login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
