@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('lang.staffs'))

@section('main-section')

<!-- Main content -->
<div class="container-fluid">
    @if($permission->manageStaff() == 1)
    <h4 class="page-title">{{ __('lang.staffs') }}
        <a href="{{ route('add-staff.createStaff') }}" class="btn btn-primary pull-right">{{ __('lang.add_new') }}</a>
    </h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @include('includes.flash')
                    @include('staff.table')
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    @else
        <div class="callout callout-warning">
            <h4>{{ __('lang.access_denied') }}</h4>

            <p>{{ __("lang.don't_have_permission") }}</p>
        </div>
    @endif
</div>
<!-- /.content -->

@endsection
