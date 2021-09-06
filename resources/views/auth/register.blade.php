@extends('layouts.master')
@section('title', __('lang.register'))

@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/auth.css') }}">
@endsection

@section('content')

<!-- particles.js container -->
<div id="particles-js"></div>

<!-- register container -->
<div class="background-image pt-5 pb-4rem">
    <div class="container">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <!-- Icon -->
                <div class="fadeIn first py-3">
                    <h5>{{ __('lang.register') }}</h5>
                </div>
                <!-- Login Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="text" id="name" class="fadeIn second {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('lang.name') }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <input type="email" id="login" class="fadeIn third {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.email') }}" required>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    <input type="password" id="password" class="fadeIn four {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('lang.password') }}" required>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                    <input type="password" id="confirm-password" class="fadeIn five" name="password_confirmation" placeholder="{{ __('lang.confirm_password') }}" required>
                    <input type="submit" class="fadeIn fourth" value="Sign Up">
                </form>
                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <div>
                        {{ __('lang.already_have_account') }}
                        <a href="{{ route('login') }}" class="bluish-text">{{ __('lang.login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
