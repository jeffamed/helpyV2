@inject('languages', 'App\Http\Controllers\SwitchLanguageController')
<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="{{ url($appUrl) }}"><img src="{{ asset($publicPath.'/images/logo.png') }}"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url($appUrl.'/#top') }}">{{ __('lang.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('KnowledgeBaseIndex') }}">{{ __('lang.knowledge_base') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url($appUrl.'/#services') }}">{{ __('lang.services') }}</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" href="{{ url($appUrl.'/#testimonials') }}">{{ __('lang.testimonials') }}</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" href="{{ url($appUrl.'/about-us') }}">{{ __('lang.about_us') }}</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" href="{{ route('contactPage') }}">{{ __('lang.contact') }}</a>
                </li>
                <li class="nav-item dropdown" style="display: none;">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle nl-border" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ ucfirst(session('locale')) }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right custom-dw" aria-labelledby="navbarDropdown">
                        @foreach($languages->getLanguage() as $key=>$language)
                            <a class="dropdown-item language" data-locale="{{ $language }}" data-lang="{{ $language }}" href="javascript:void(0)">{{ ucfirst($language) }}</a>
                        @endforeach
                    </div>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('lang.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('lang.register') }}</a>
                    </li>

                @else

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right custom-dw" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                {{__('lang.dashboard')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('lang.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</section>
