@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('lang.department_tickets'))

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageTicket() == 1)
        <h4 class="page-title">#{{ $tickets[0]['department']['title'] }} {{ __('lang.department_tickets') }}
            <a href="{{ route('department.index') }}" class="btn btn-primary btn-md pull-right">{{ __('lang.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="deptID" data-dept="{{ $tickets[0]['department']['id'] }}">
                    @include('departments.ticket-table')
                    {{--<div class="card-body table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                            <tr>
                                <th>{{ __('lang.sl_no') }}</th>
                                <th>{{ __('lang.department') }}</th>
                                <th>{{ __('lang.title') }}</th>
                                <th>{{ __('lang.user_name') }}</th>
                                <th>{{ __('lang.status') }}</th>
                                <th>{{ __('lang.last_updated') }}</th>
                                <th>{{ __('lang.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($tickets->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('lang.currently_no_tickets') }}</td>
                                </tr>
                                
                            @else
                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td>{{ $loop->index +1 }}</td>
                                        <td>{{ $ticket->department->title }}</td>
                                        <td>
                                            <a href="{{ route('ticket.show', $ticket->ticket_id) }}">
                                                #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                                            </a>
                                        </td>
                                        <td>{{ $ticket->user->name }}</td>
                                        <td>
                                            @if ($ticket->status === 'Open')
                                                <span class="badge bg-success">{{ $ticket->status }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ $ticket->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $ticket->updated_at->toDayDateTimeString() }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('ticket.show', $ticket->ticket_id) }}" class="badge bg-primary text-white">{{ __('lang.reply') }}</a>
                                            @if($ticket->status === 'Open')
                                            <form action="{{ route('close_ticket.close',$ticket->ticket_id) }}" method="POST">
                                                {!! csrf_field() !!}
                                                <button type="submit" class="badge bg-red">{{ __('lang.close') }}</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $tickets->links() }}
                    </div>--}}
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