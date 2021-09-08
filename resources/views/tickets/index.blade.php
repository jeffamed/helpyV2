@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', 'Tickets')

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageTicket() == 1 || Auth::user()->user_type == 1)
        <h4 class="page-title">{{ __('lang.tickets') }}
            <a href="{{ route('submit-new-ticket.create') }}" target="_blank" class="btn btn-primary btn-md pull-right">{{ __('lang.add_new') }}</a>
            <a href="{{ route('export-all-ticket') }}" class="btn btn-success btn-md pull-right mr-2"><i class="fa fa-file-excel-o" aria-hidden="true"></i> {{ __('lang.export') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="ticketType" data-type="all">
                    <!-- /.box-header -->
                    @include('tickets.table', ['departments' => $departments, 'options' => $options, 'optType' => $optType])
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

                <p>{{ __("lang.don't have permission") }}</p>
            </div>
        @endif
    </div>
    <!-- /.content -->

@endsection