@inject('notifications', 'App\Http\Controllers\NotificationController')

<div class="logo-header">
    <a href="{{ route('dashboard') }}" class="logo">
        {{ $gs->app_name ?? config('devstar.app_name') }}
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="la la-bars"></i>
    </button>
    <button class="topbar-toggler more">
        <i class="la la-ellipsis-v"></i>
    </button>
</div>
<nav class="navbar navbar-header navbar-expand-lg">
    <div class="container-fluid">
        @php
            $user = Auth::user();
        @endphp
        
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <navbar-component></navbar-component>
          <li class="nav-item dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    @if($user->avatar)
                        <img src="{{ asset(symImagePath().$user->avatar) }}" alt="avatar" width="36" class="img-circle">
                    @else
                        <img src="{{ asset($publicPath.'/uploads/profile/default.jpg') }}" alt="avatar" width="36" class="img-circle">
                    @endif
                    <span>{{ $user->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <div class="user-box">
                            <div class="u-img">
                                @if($user->avatar)
                                    <img src="{{ asset(symImagePath().$user->avatar) }}" alt="user">
                                @else
                                    <img src="{{ asset($publicPath.'/uploads/profile/default.jpg') }}" alt="user">
                                @endif
                            </div>
                            <div class="u-text">
                                <h4> {{ $user->name }}</h4>
                                <p class="text-muted">{{ $user->email }}</p>
                            </div>
                        </div>
                    </li>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="la la-user"></i> {{ __('lang.my_profile') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="la la-power-off"></i> {{ __('lang.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
                <!-- /.dropdown-user -->
            </li>
        </ul>
    </div>
</nav>