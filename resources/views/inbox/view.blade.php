@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', 'View Contact Message Inbox')
@section('main-section')

<div class="row">
    <div class="col-md-12">
        @if($permission->manageInbox() == 1)
        <div class="card">
            <div class="card-body">
                <div class="card-sub">
                    <h6>{{ __('lang.view_contact_message') }}</h6>
                </div>
                <div class="">
                	<p>{{ __('lang.name') }}: {{ $contact->name }}</p>
                	<p>{{ __('lang.phone') }}: {{ $contact->phone }}</p>
                	<p>{{ __('lang.email') }}: {{ $contact->email }}</p>
                	<p>{{ __('lang.message_at') }}: {{ $contact->created_at->toDayDateTimeString() }}</p>
                	<p>{{ __('lang.message') }}:<br>
                        {{ $contact->message }}
                    </p>
                </div>
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