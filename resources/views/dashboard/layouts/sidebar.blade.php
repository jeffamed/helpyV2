<div class="sidebar" id="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        @if(Auth::user()->is_admin)
            <p class="nav pl-4 text-muted">{{ __('lang.version') }}: {{ config('devstar.app_version') }}</p>
        @endif
        <ul class="nav">
            <li class="nav-item" id="dashboard">
                <a href="{{ route('dashboard') }}">
                    <i class="la la-dashboard"></i>
                    <p>{{ __('lang.dashboard') }}</p>
                </a>
            </li>
            @if(!Auth::user()->is_admin &&  Auth::user()->user_type == 0)
            <li class="nav-item" id="knowledge">
                <a href="{{ route('submit-new-ticket.create') }}" target="_blank">
                    <i class="fa fa-ticket"></i>
                    <p>{{ __('lang.add_new_ticket') }}</p>
                </a>
            </li>
            <li class="nav-item" id="dashboard">
                <a href="{{ route('KnowledgeBaseIndex') }}" target="_blank">
                    <i class="la la-book"></i>
                    <p>{{ __('lang.knowledge') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageTicket() == 1)
            <li id="tickets" class="nav-item">
                <div id="ticketsID">
                    <a href="#submenuTickets" data-toggle="collapse" aria-expanded="false" class="list-group-item border-0">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-ticket fa-fw mr-3"></span> 
                            <span class="menu-collapsed">{{ __('lang.tickets') }}</span>
                            <span class="submenu-icon ml-auto"></span>
                        </div>
                    </a>
                </div>
                
                <!-- Submenu content -->
                <ul id='submenuTickets' class="collapse sidebar-submenu">
                    <li class="alltickets {{ (request()->segment(1) == 'tickets') ? 'active': '' }}">
                        <a href="{{ route('tickets.index') }}" class="border-0">
                        <span class="menu-collapsed">{{ __('lang.all_tickets') }}</span>
                        </a>
                    </li>
                    <li class="opened-tickets {{ (request()->segment(1) == 'opened-tickets') ? 'active': '' }}">
                        <a href="{{ route('opened-tickets.openedTickets') }}" class="border-0">
                            <span class="menu-collapsed">{{ __('lang.open_tickets') }}</span>
                        </a>
                        
                    </li>
                    <li class="closed-tickets {{ (request()->segment(1) == 'closed-tickets') ? 'active': '' }}">
                       <a href="{{ route('closed-tickets.ClosedTickets') }}" class="border-0">
                            <span class="menu-collapsed">{{ __('lang.closed_tickets') }}</span>
                        </a> 
                    </li>
                    
                    <li class="closed-tickets {{ (request()->segment(1) == 'custom-fields') ? 'active': '' }}">
                       <a href="{{ route('CustomFields') }}" class="border-0">
                            <span class="menu-collapsed">{{ __('lang.custom_fields') }}</span>
                        </a> 
                    </li>
                    
                </ul>
            </li>
            @endif
            @if($permission->manageDepartment() == 1 )
            <li class="nav-item" id="department">
                <a href="{{ route('departments.index') }}">
                    <i class="la la-th-list"></i>
                    <p>{{ __('lang.departments') }}</p>
                </a>
            </li>
            @endif
            
            @if($permission->manageKB() == 1 )
            <li class="nav-item" id="kb">
                <a href="{{ route('knowledge-base.index') }}">
                    <i class="la la-leanpub"></i>
                    <p>{{ __('lang.knowledge_base') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageStaff() == 1 )
            <li class="nav-item" id="staff">
                <a href="{{ route('staffs.staffList') }}">
                    <i class="la la-user-secret"></i>
                    <p>{{ __('lang.staffs') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageUser() == 1 )
            <li class="nav-item" id="users">
                <a href="{{ route('users.userList') }}">
                    <i class="la la-user"></i>
                    <p>{{ __('lang.users') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageRole() == 1 )
            <li class="nav-item" id="roles">
                <a href="{{ route('roles.index') }}">
                    <i class="la la-shield"></i>
                    <p>{{ __('lang.manage_roles') }}</p>
                </a>
            </li>
            @endif

            @if($permission->manageAppSetting() == 1 || $permission->manageEmailSetting() == 1 || $permission->manageEmailTemplate() == 1)
            <li class="nav-item" id="settings">
                <div id="appSettings">
                    <a href="#submenuSetting" data-toggle="collapse" aria-expanded="false" class="list-group-item border-0">
                    <i class="la la-gears"></i> <span>{{ __('lang.settings') }}</span>
                        <span class="submenu-icon ml-auto"></span>
                    </a>
                </div>
                
                <ul id='submenuSetting' class="collapse sidebar-submenu">
                    @if($permission->manageAppSetting() == 1)
                        <li><a href="{{ route('app-settings.settingIndex') }}">{{ __('lang.app_setting') }}</a></li>
                    @endif
                    @if($permission->manageEmailSetting() == 1)
                        <li><a href="{{ route('emailSetting') }}">{{ __('lang.email_setting') }}</a></li>
                    @endif
                    @if($permission->manageEmailTemplate() == 1)
                        <li><a href="{{ route('email-template.index') }}">{{ __('lang.email_template') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if($permission->manageLogoIcon() == 1 || $permission->manageSocialLink() == 1 || $permission->manageHowWork() == 1 || $permission->manageCounter() == 1 || $permission->manageBanerText() == 1 || $permission->manageTestimonial() == 1 || $permission->manageService() == 1 || $permission->manageAboutUs() == 1 || $permission->manageFooter() == 1)
            <li class="nav-item" id="frontend">
                <div id="webSetting">
                    <a href="#submenuFrontend" data-toggle="collapse" aria-expanded="false" class="list-group-item border-0">
                    <i class="fa fa-fw fa-list"></i> <span>{{ __('lang.frontend_settings') }}</span>
                        <span class="submenu-icon ml-auto"></span>
                    </a>
                </div>
                
                <ul id='submenuFrontend' class="collapse sidebar-submenu">
                    @if($permission->manageLogoIcon() == 1)
                        <li><a href="{{ route('logoIcon.Setting') }}">{{ __('lang.logo_icon') }}</a></li>
                    @endif
                    @if($permission->manageSocialLink() == 1)
                        <li><a href="{{ route('social.Setting') }}">{{ __('lang.social_link') }}</a></li>
                    @endif
                    @if($permission->manageBanerText() == 1)
                        <li><a href="{{ route('headerTextSetting') }}">{{ __('lang.banner_text') }}</a></li>
                    @endif
                    @if($permission->manageHowWork() == 1)
                        <li><a href="{{ route('how-we-work.index') }}">{{ __('lang.how_we_work') }}</a></li>
                    @endif
                    @if($permission->manageService() == 1)
                        <li><a href="{{ route('service.index') }}">{{ __('lang.service_setting') }}</a></li>
                    @endif
                    @if($permission->manageCounter() == 1)
                        <li><a href="{{ route('counter.Setting') }}">{{ __('lang.counter_setting') }}</a></li>
                    @endif
                    @if($permission->manageTestimonial() == 1)
                        <li><a href="{{ route('testimonial.index') }}">{{ __('lang.testimonial') }}</a></li>
                    @endif
                    @if($permission->manageAboutUs() == 1)
                        <li><a href="{{ route('aboutus.Setting') }}">{{ __('lang.about_us') }}</a></li>
                    @endif
                    @if($permission->manageFooter() == 1)
                        <li><a href="{{ route('footer.Setting') }}">{{ __('lang.footer') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if(Auth::user()->is_admin)
            <li class="nav-item" id="inbox">
                <a href="{{ route('contactMessage') }}">
                    <i class="la la-envelope"></i>
                    <p>{{ __('lang.inbox') }}</p>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>