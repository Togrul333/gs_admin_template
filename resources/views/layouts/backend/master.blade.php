<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('backend.includes.meta')
    @include('backend.includes.styles')
    @stack('extrahead')
    @yield('styles')
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
@auth('admin')
    @include('backend.includes.mobile')
@endauth
<div class="d-flex flex-column flex-root">
    @if(auth()->guard('admin')->check())
        <div class="d-flex flex-row flex-column-fluid page">
            @include('backend.includes.sidebar')
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                @include('backend.includes.header')
                @yield('content')
                @include('backend.includes.footer')
            </div>
        </div>
    @else
        @yield('content')
    @endif
</div>
@auth('admin')
    @include('backend.includes.user')
@endauth
@include('backend.includes.scripts')
@yield('scripts')
@stack('extrascripts')
@include('backend.includes.notification')
</body>
</html>
