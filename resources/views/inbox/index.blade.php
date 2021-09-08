@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('lang.contact_message_inbox'))
@section('main-section')

<div class="row">
    <div class="col-md-12">
        @if($permission->manageInbox() == 1)
        <div class="card">
            <div class="card-body">
                <div class="card-sub">
                    <h6>{{ __('lang.contact_message_inbox') }}</h6>
                </div>
                <table class="table mt-3">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('lang.name') }}</th>
                        <th scope="col">{{ __('lang.phone') }}</th>
                        <th scope="col">{{ __('email') }}</th>
                        <th scope="col">{{ __('lang.date') }}</th>
                        <th scope="col">{{ __('lang.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($messages as $message)
                    <tr @if($message->status == 0) class="bg-light" @endif>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $message->name }}</td>
                        <td>
                            <a href="{{ route('readMessage', $message->id) }}">
                                {{ $message->phone }}
                            </a>
                        </td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->created_at->toDayDateTimeString() }}</td>
                        <td>
                            <a href="{{ route('readMessage', $message->id) }}" class="badge badge-primary" title="View">{{ __('lang.view') }}</a>
                            <form id="delete-form-{{ $message->id }}" method="post" action="{{ route('message.destroy', $message->id) }}" style="display: none">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                            </form>
                            <a href="" class="badge bg-danger text-white" onclick="
                                    if(confirm('Are you sure, You want to Delete this ??'))
                                    {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $message->id }}').submit();
                                    }
                                    else {
                                    event.preventDefault();
                                    }"><i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                        <div class="text-center">{{ __('lang.currently_no_messages_found') }}</div>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                
            </div>
        </div>
        @else
            <div class="callout callout-warning">
                <h4>{{ __('lang.access_denied') }}</h4>

                <p>{{ __("lang.don't_have_permission") }}</p>
            </div>
        @endif
    </div>
</div>
@endsection