@extends('dashboard.master')

@inject('permission', 'App\Http\Controllers\PermissionController')
@section('style')

@stop

@section('title', __('lang.add_new_role'))

@section('main-section')
    <div class="container-fluid">
        @if($permission->manageRole() == 1)
        <h4 class="page-title">{{ __('lang.save_new_roles') }}
            <a href="{{ route('roles.index') }}" class="btn btn-primary pull-right">{{ __('lang.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('includes.flash')
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="mx-auto w-50" method="POST" action="{{ route('role-save.store') }}">
                        {!! csrf_field() !!}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">{{ __('lang.title') }}</label>
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="{{ __('lang.enter_role_name') }}" required>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="box-header my-1">
                                <h6 class="box-title">{{__('lang.settings')}}</h6>
                            </div>
                            <!-- Minimal style -->
                            <!-- checkbox -->
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-1" value="can_manage_app_setting" name="permissions[]">
                                <label for="role-1" class="font-weight-normal">{{ __('lang.can_manage_app_setting') }}</label>
                                <span></span>
                            </div>
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="setting-2" value="can_manage_email_setting" name="permissions[]">
                                <label for="setting-2" class="font-weight-normal">{{ __('lang.can_manage_email_setting') }}</label>
                                <span></span>
                            </div>

                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-4" value="can_manage_email_template" name="permissions[]">
                                <label for="role-4" class="font-weight-normal">{{ __('lang.can_manage_email_template') }}</label>
                                <span></span>
                            </div>

                            <div class="box-header my-1">
                                <h6 class="box-title">{{ __('lang.frontend_settings') }}</h6>
                            </div>
                            <!-- Minimal style -->
                            <!-- checkbox -->
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-10" value="can_manage_logo_icon" name="permissions[]">
                                <label for="role-10" class="font-weight-normal">{{ __("lang.can_manage_logo_icon") }}</label>
                                <span></span>
                            </div>
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-11" value="can_manage_social_link" name="permissions[]">
                                <label for="role-11" class="font-weight-normal">{{ __("lang.can_manage_social_link") }}</label>
                                <span></span>
                            </div>

                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-12" value="can_manage_baner_text" name="permissions[]">
                                <label for="role-12" class="font-weight-normal">{{ __("lang.can_manage_baner_text") }}</label>
                                <span></span>
                            </div>

                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-13" value="can_manage_testimonial" name="permissions[]">
                                <label for="role-13" class="font-weight-normal">{{ __('lang.can_manage_testimonial') }}</label>
                                <span></span>
                            </div>

                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-14" value="can_manage_service" name="permissions[]">
                                <label for="role-14" class="font-weight-normal">{{ __('lang.can_manage_service') }}</label>
                                <span></span>
                            </div>

                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-15" value="can_manage_aboutus" name="permissions[]">
                                <label for="role-15" class="font-weight-normal">{{ __('lang.can_manage_about_us') }}</label>
                                <span></span>
                            </div>

                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-16" value="can_manage_footer" name="permissions[]">
                                <label for="role-16" class="font-weight-normal">{{ __('lang.can_manage_footer') }}</label>
                                <span></span>
                            </div>

                            <div class="box-header my-2">
                                <h6 class="box-title">{{ __('lang.tickets') }}</h6>
                            </div>
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-5" value="can_manage_tickets" name="permissions[]">
                                <label for="role-5" class="font-weight-normal">{{ __('lang.can_manage_tickets') }}</label>
                                <span></span>
                            </div>

                            <div class="box-header my-2">
                                <h6 class="box-title">{{ __('lang.departments') }}</h6>
                            </div>
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-6" value="can_manage_department" name="permissions[]">
                                <label for="role-6" class="font-weight-normal">{{ __('lang.can_manage_department') }}</label>
                                <span></span>
                            </div>

                            <div class="box-header my-2">
                                <h6 class="box-title">{{ __('lang.knowledge_base') }}</h6>
                            </div>
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-7" value="can_manage_kb" name="permissions[]">
                                <label for="role-7" class="font-weight-normal">{{ __('lang.can_manage_knowledge_base') }}</label>
                                <span></span>
                            </div>

                            <div class="box-header my-2">
                                <h6 class="box-title">{{ __('lang.staffs') }}</h6>
                            </div>
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-8" value="can_manage_staff" name="permissions[]">
                                <label for="role-8" class="font-weight-normal">{{ __('lang.can_manage_staff') }}</label>
                                <span></span>
                            </div>

                            <div class="box-header my-2">
                                <h6 class="box-title">{{ __('lang.users') }}</h6>
                            </div>
                            <div class="form-group minimal">
                                <input type="checkbox" class="minimal" id="role-9" value="can_manage_user" name="permissions[]">
                                <label for="role-9" class="font-weight-normal">{{ __('lang.can_manage_user') }}</label>
                                <span></span>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="card-footer mb-3">
                            <button type="submit" class="btn btn-primary btn-block text-uppercase">{{ __('lang.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
            <div class="callout callout-warning">
                <h4>{{ __('lang.access_denied') }}</h4>

                <p>{{ __("lang.don't_have_permission") }}</p>
            </div>
        @endif
    </div>

@endsection