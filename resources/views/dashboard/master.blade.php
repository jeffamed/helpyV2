@inject('permission', 'App\Http\Controllers\PermissionController')
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - {{ __('lang.dashboard') }}</title>
    @include('dashboard.layouts.head')
    @yield('style')
</head>
<body>
<div class="wrapper" id="app">
    <div class="main-header shadow-nav">
        
        @include('dashboard.layouts.navbar')
    </div>

    @include('dashboard.layouts.sidebar')

    <div class="main-panel">
        <div class="content">
            <!-- main content -->
            @yield('main-section')
        </div>
    </div>
</div>

<script>
    window.appUrl = '{{ $appUrl }}';
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>

@yield('js')
<script src="{{ asset('assets/js/main.js') }}"></script>

<!--toastr message-->
@include('includes.toasterMessage')
</body>
</html>