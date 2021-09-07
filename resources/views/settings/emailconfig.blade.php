@inject('permission', 'App\Http\Controllers\PermissionController')

@extends('dashboard.master')
@section('title', __('lang.email_setting'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageEmailSetting() == 1)
    <h4 class="page-title">{{ __('lang.email_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            @include('includes.flash')
            <form action="{{ route('emailSettingUpdate',$setting->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emailSendName">{{ __('lang.email_send_from_name') }}</label>
                            <input type="text" name="from_name" value="{{ $setting->from_name ?? old('from_name') }}" class="form-control {{ $errors->has('from_name') ? ' is-invalid' : '' }}" id="emailSendName" placeholder="{{ __('lang.enter_email_from_name') }}">
                        </div>
                        @if ($errors->has('from_name'))
                            <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('from_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_email">{{ __('lang.from_email') }}</label>
                            <input type="text" name="from_email" value="{{ $setting->from_email ?? old('from_email') }}" class="form-control {{ $errors->has('from_email') ? ' is-invalid' : '' }}" id="from_email" placeholder="{{ __('lang.enter_from_email') }}">
                        </div>
                        @if ($errors->has('from_email'))
                            <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('from_email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emailDriver">{{ __('lang.email_driver') }}</label>
                            <select class="form-control" id="emailDriver" name="mail_driver">
                                <option value="smtp" @if($setting->mail_driver==='smtp') selected @endif>{{ __('SMTP') }}</option>
                                <option value="sendmail" @if($setting->mail_driver==='sendmail') selected @endif>{{ __('Sendmail') }}</option>
                                <option value="mandrill" @if($setting->mail_driver==='mandrill') selected @endif>{{ __('Mandrill') }}</option>
                                <option value="mailgun" @if($setting->mail_driver==='mailgun') selected @endif>{{ __('Mailgun') }}</option>
                                <option value="sparkpost" @if($setting->mail_driver==='sparkpost') selected @endif>{{ __('SparkPost') }}</option>
                                <option value="ses" @if($setting->mail_driver==='ses') selected @endif>{{ __('SES') }}</option>
                                <option value="postmark" @if($setting->mail_driver==='postmark') selected @endif>{{ __('PostMark') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpHost" @if($setting->mail_driver !== 'smtp') style="display: none;" @endif>
                        <div class="form-group">
                            <label for="emailHost">{{ __('lang.smtp_host') }}</label>
                            <input type="text" name="smtp_host" value="{{ $setting->smtp_host ?? old('smtp_host') }}" class="form-control" id="emailHost" placeholder="{{ __('lang.enter_smtp_host') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpPort" @if($setting->mail_driver !== 'smtp') style="display: none;" @endif>
                        <div class="form-group">
                            <label for="emailPort">{{ __('lang.smtp_port') }}</label>
                            <input type="number" name="smtp_port" value="{{ $setting->smtp_port ?? old('smtp_port') }}" class="form-control" id="emailPort" placeholder="{{ __('lang.enter_smtp_port') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpUsername" @if($setting->mail_driver !== 'smtp') style="display: none;" @endif>
                        <div class="form-group">
                            <label for="smtpUsername">{{ __('lang.smtp_username') }}</label>
                            <input type="text" name="smtp_username" value="{{ $setting->smtp_username ?? old('smtp_username') }}" class="form-control" id="smtpUsername" placeholder="{{ __('lang.enter_smtp_username') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpPassword" @if($setting->mail_driver !== 'smtp') style="display: none;" @endif>
                        <div class="form-group">
                            <label for="emailPassword">{{ __('lang.smtp_password') }}</label>
                            <input type="text" name="smtp_password" value="{{ $setting->smtp_password ?? old('smtp_password') }}" class="form-control" id="emailPassword" placeholder="{{ __('lang.enter_smtp_password') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="encryption" @if($setting->mail_driver !== 'smtp') style="display: none;" @endif>
                        <div class="form-group">
                            <label for="emailEncryption">{{ __('lang.encryption_type') }}</label>
                            <select name="smtp_encryption" id="emailEncryption" class="form-control">
                                <option disabled selected>{{ __('lang.select_one') }}</option>
                                <option value="tls" {{ $setting->smtp_encryption == 'tls' ? 'selected' : '' }}>{{ __('TLS') }}</option>
                                <option value="ssh" {{ $setting->smtp_encryption == 'ssh' ? 'selected' : '' }}>{{ __('SSH') }}</option>
                                <option value="ssl" {{ $setting->smtp_encryption == 'ssl' ? 'selected' : '' }}>{{ __('SSL') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="testMail">{{ __('lang.enter_test_mail') }}</label>
                        <input type="email" name="test_mail" value="{{ old('test_mail') }}" class="form-control" id="testMail" placeholder="{{ __('lang.enter_test_mail') }}">
                    </div>
                </div>

                <div class="card-footer col-md-12">
                    <button type="submit" class="btn btn-primary btn-block text-uppercase">{{ __('lang.update') }}</button>
                </div>
            </form>
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