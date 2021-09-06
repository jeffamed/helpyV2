@extends('dashboard.master')
@section('title', __('lang.dashboard'))
@section('main-section')
    @php
        $user = Auth::user();
    @endphp
    <div class="container-fluid">
        <h4 class="page-title">{{ __('lang.dashboard') }}</h4>
        @if($user->is_admin)
            @widget('DasboardCounterStatus')
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="ticketType" @if($user->is_admin == 1 ||  $user->user_type == 1)data-type="open" @else data-type="all" @endif>
                    <div class="card-body table-responsive">
                        <div class="card-sub">
                            <h6>
                                @if($user->is_admin == 1 ||  $user->user_type == 1)
                                    {{ __('lang.open_tickets') }}
                                @else
                                    {{ __('lang.my_tickets') }}
                                @endif
                                <a href="{{ route('export-all-ticket') }}" class="btn btn-success btn-md pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i> {{ __('lang.export') }}</a>
                            </h6>
                        </div>
                            @include('tickets.table', ['departments' => $departments])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
