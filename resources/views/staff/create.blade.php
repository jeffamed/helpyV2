@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')
@section('title', __('lang.add_new_staff'))

@section('main-section')
    <div class="container-fluid">
        @if($permission->manageStaff() == 1)
        <h4 class="page-title">{{ __('lang.add_new_staff') }}
            <a href="{{ route('staffs.staffList') }}" class="btn btn-primary pull-right">{{ __('lang.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                @include('includes.flash')
                <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="" method="POST" action="{{ route('save-staff.saveStaff') }}">
                        {!! csrf_field() !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('lang.name') }}</label>
                                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('lang.enter_name') }}" required>

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
                                        <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.enter_email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback d-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department">{{ __('lang.department') }}</label>
                                        <select id="department" class="form-control" name="department" required>
                                            <option value="">{{ __('lang.select_department') }}</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department') === $department->id ? 'selected' : '' }}>{{ $department->title }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('department'))
                                            <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('department') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role_id">{{ __('lang.role') }}</label>
                                        <select id="role_id" type="" class="form-control" name="role" required>
                                            <option value="">{{ __('lang.select_role') }}</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('lang.status') }}</label>
                                        <select id="status" type="" class="form-control" name="status" required>
                                            <option value="">{{ __('lang.select_status') }}</option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>{{ __('lang.active') }}</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>{{ __('lang.inactive') }}</option>
                                        </select>

                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">{{ __('lang.password') }}</label>
                                        <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-footer mb-3">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('lang.add_staff') }}</button>
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