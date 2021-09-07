@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')
@section('title', __('lang.edit_user_info'))

@section('main-section')
    <div class="container-fluid">
        @if($permission->manageStaff() == 1)
        <h4 class="page-title">{{ __('lang.update') }} #{{ $user->id }} - {{ $user->name }} {{ __('lang.user_info') }}
            <a href="{{ route('users.userList') }}" class="btn btn-primary pull-right">{{ __('lang.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                @include('includes.flash')
                <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('userUpdate', $user->id) }}">
                        {!! csrf_field() !!}
                        {{ method_field('put')}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('lang.name') }}</label>
                                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" name="name" value="{{ $user->name }}">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback d-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('lang.email') }}</label>
                                        <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ $user->email }}">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback d-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('lang.status') }}</label>
                                        <select id="status" type="" class="form-control {{ $errors->has('status') ? ' has-error' : '' }}" name="status">
                                            <option value="1" {{ $user->status == '1' ? 'selected' : '' }}>{{ __('lang.active') }}</option>
                                            <option value="0" {{ $user->status == '0' ? 'selected' : '' }}>{{ __('lang.inactive') }}</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">{{ __('lang.password') }}</label>
                                        <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" name="password">

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback d-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="box-footer mb-3">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('lang.update') }}</button>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </form>
                </div>
            </div>
        </div>
        @else
            <div class="callout callout-warning">
                <h4>{{ __('lang.access_denied') }}</h4>

                <p>{{ __("lang.don't have permission") }}</p>
            </div>
        @endif
    </div>
@endsection