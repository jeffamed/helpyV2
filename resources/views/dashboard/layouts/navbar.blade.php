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
            $user = collect([
                ['name' => 'ammed Moraga'],
                ['email' => 'jeffamed@gmail.com']
                ]);
        @endphp
        
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown">
                <a href="{{ route('homePage') }}" class="pr-3">{{ __('lang.home') }}</a>
                  <a class="nav-link countUp" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell notify"></i>
                    <span class="count notifyCount">{{ $notifications->count() }}</span>
                  </a>
                    <ul class="dropdown-menu">
                      <li class="head">
                        <div class="row">
                          <div class="col-lg-12 col-sm-12 col-12 pb-2 border-bottom">
                            <span>{{ __('lang.notifications') }}</span>
                          </div>
                      </li>

                      <li class="notification-box">
                        <div class="">
                          @forelse($notifications->index() as $notify)  
                          <div class="px-2 @if(!$loop->last) border-bottom @endif ">
                                <div>
                                <?php $data = json_decode($notify->data); $title = $data->{'title'}; $id = $data->{'ticket_id'}; ?>
                                  <a href="{{ route('ticket.show', $id) }}"> {{ $title }}</a>
                                </div>
                                <small class="text-warning">{{ $notify->created_at->format('Y-m-d') }} - {{ $notify->created_at->diffForHumans() }}</small>
                                
                              </div>
                          @empty
                              <div class="px-2">
                                  {{ __('lang.notification_empty') }}
                              </div>

                          @endforelse
                        </div>
                      </li>
                      <li class="footer text-center">
                        <a href="{{ route('allNotification') }}" class="text-info">{{ __('lang.view_all') }}</a>
                      </li>
                    </ul>
                </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <img src="{{ asset($publicPath.'/uploads/profile/default.jpg') }}" alt="avatar" width="36" class="img-circle">
                    <span>ammed moraga</span>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <div class="user-box">
                            <div class="u-img">
                                <img src="{{ asset($publicPath.'/uploads/profile/default.jpg') }}" alt="user">
                            </div>
                            <div class="u-text">
                                <h4> ammed moraga</h4>
                                <p class="text-muted">jeffamed@gmail.com</p>
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