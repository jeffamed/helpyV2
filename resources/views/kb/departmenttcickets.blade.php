@extends('layouts.app')

@section('title', __('lang.department_tickets'))

@section('content')

    <div class="container">
        <div class="pb-20p"></div>
        <div class="card">
            <h5 class="card-header">{{ __('lang.tickets') }}</h5>
            <div class="card-body">
                @if ($tickets->tickets->isEmpty())
                    <p>{{ __('lang.currently_no_tickets') }}</p>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ __('lang.title') }}</th>
                            <th>{{ __('lang.status') }}</th>
                            <th>{{ __('lang.last_updated') }}</th>
                            <th class="text-center" colspan="2">{{ __('lang.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets->tickets as $ticket)
                            <tr>
                                <td>
                                    <a href="{{ route('show', $ticket->ticket_id) }}">
                                        #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                                    </a>
                                </td>
                                <td>
                                    @if ($ticket->status === 'Open')
                                        <span class="badge badge-success">{{ $ticket->status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $ticket->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $ticket->updated_at }}</td>
                                <td>
                                    <a href="{{ route('show', $ticket->ticket_id) }}" class="btn btn-primary">{{ __('lang.comment') }}</a>
                                </td>
                                <td>
                                    <form action="{{ route('close', $ticket->ticket_id) }}" method="POST">
                                        {!! csrf_field() !!}
                                        <button type="submit" class="btn btn-danger">{{ __('lang.close') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

@endsection