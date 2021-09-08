@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('lang.social_link'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageSocialLink() == 1)
    <h4 class="page-title">{{ __('lang.social_link') }}
        <a href="javascript:void(0);" class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#addNew">
            <i class="fa fa-plus"></i> {{ __('lang.add_new') }}
        </a>
    </h4>
    
    <div class="card mb-4">
        <div class="card-body">
            <table id="table" class="table table-sm table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>{{ __('lang.sl_no') }}</th>
                        <th>{{ __('lang.name') }}</th>
                        <th>{{ __('lang.icon') }}</th>
                        <th>{{ __('lang.link') }}</th>
                        <th>{{ __('lang.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($socialList as $key=>$social)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $social->name }}</td>
                        <td><i class="{{ $social->code }}"></i></td>
                        <td>{{ $social->link }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit{{ $social->id }}" title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div class="modal fade" id="edit{{ $social->id }}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> {{ __('lang.edit_social') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <form method="POST" action="{{ route('socialUpdate.Setting',$social->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group error">
                                                    <label for="name" class="col-sm-3 control-label bold uppercase"><strong>{{ __('lang.name') }} :</strong> </label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control has-error bold " value="{{ $social->name ?? old('name') }}" id="name" name="name" placeholder="Social Name">
                                                    </div>
                                                </div>
                                                <div class="form-group error">
                                                    <label for="code" class="col-sm-3 control-label bold uppercase"><strong>{{ __('lang.icon_code') }} :</strong> </label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control has-error bold demo" id="code" value="{{ $social->code ?? old('code') }}" name="code" placeholder="Enter Fontawesome icon like fa fa-facebook">
                                                        <small class="text-danger"><strong>For Fontawesome code visit : https://fontawesome.com/v4.7.0/icons/</strong><br> Enter Fontawesome icon like fa fa-facebook</small>
                                                    </div>
                                                </div>
                                                <div class="form-group error">
                                                    <label for="link" class="col-sm-3 control-label bold uppercase"><strong>Link :</strong> </label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control has-error bold " value="{{ $social->link ?? old('link') }}" id="link" name="link" placeholder="Social Link">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('lang.close') }}</button>
                                                <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('lang.save_Social') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm delete_button" data-toggle="modal" data-target="#delete{{ $social->id }}" title="DELETE">
                                <i class="fa fa-trash"></i>
                            </button>
                            <div class="modal fade" id="delete{{ $social->id }}" role="dialog" aria-labelledby="#delete{{ $social->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('socialDestroy.Setting',$social->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="delete"><i class="fa fa-trash"></i>&nbsp;{{ __('lang.delete') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>{{ __('lang.are_you_sure_you_want_to_delete') }}</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('lang.no') }}</button>
                                                <button type="submit" class="btn btn-danger">{{ __('lang.delete') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>                 
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- add new modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> {{ __('lang.manage_social') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form method="POST" action="{{ route('socialAdd.Setting') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group error">
                            <label for="name" class="col-sm-3 control-label bold uppercase"><strong>{{ __('lang.name') }} :</strong> </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="name" name="name" placeholder="{{ __('lang.social_name') }}" required>
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="code" class="col-sm-3 control-label bold uppercase"><strong>{{ __('lang.icon_code') }} :</strong> </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold demo" id="code" name="code" placeholder="Enter Fontawesome icon like fa fa-facebook" required>
                                <small class="text-danger"><strong>{{ __('lang.for_fontawesome_code_visit') }} : https://fontawesome.com/v4.7.0/icons/</strong> <br> {{ __('lang.enter_fontawesome_icon_like') }} fa fa-facebook</small>
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="link" class="col-sm-3 control-label bold uppercase"><strong>{{ __('lang.link') }} :</strong> </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="link" name="link" placeholder="{{ __('lang.social_link') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('lang.close') }}</button>
                        <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('lang.save_Social') }}</button>
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