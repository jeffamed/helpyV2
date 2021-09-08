@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('lang.about_us_setting'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageAboutUs() == 1)
    <h4 class="page-title">{{ __('lang.about_us_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('updateAboutUs.Setting') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="aboutus_title text-uppercase"><strong>{{ __('lang.about_us_title') }}</strong></label>
                                    <input id="aboutus_title" class="form-control mb-3 {{ $errors->has('aboutus_title') ? ' is-invalid' : '' }}" name="aboutus_title" value="{{ $setting->aboutus_title ?? old('aboutus_title') }}"  type="text" required>
                                    <input class="form-control mb-3" name="id" value="{{ $setting->id }}"  type="hidden">
                                    @if ($errors->has('aboutus_title'))
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('aboutus_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="aboutus_details strong"><strong>{{ __('lang.about_us_details') }}</strong></label>
                                    <textarea class="form-control {{ $errors->has('aboutus_title') ? ' is-invalid' : '' }}" id="aboutus_details" rows="8" name="aboutus_details" required>{{ $setting->aboutus_details ?? old('aboutus_details') }}</textarea>
                                    @if ($errors->has('aboutus_details'))
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('aboutus_details') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>    
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aboutus_image"><strong>{{ __('lang.about_us_image') }}</strong></label>
                            <input id="aboutus_image" class="form-control mb-3" type="file" name="aboutus_image">
                            <small class="text-danger">{{ __('lang.image_will_be_resize_at') }} 530*482 [{{ __('lang.image_format') }}: JPG,JPEG]</small>
                        </div>
                        <img class="thumbnail img-thumbnail" src="{{asset('images/bg/about_details.jpg')}}"/>
                    </div>
                </div>
                <div class="col-md-12 my-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('lang.update') }}</button>
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