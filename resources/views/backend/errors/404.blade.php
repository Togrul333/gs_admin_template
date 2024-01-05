
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@lang('backend.titles.404')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('backend/img/favicon.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="{{asset('backend/css/error.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/plugins.bundle.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/prismjs.bundle.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style.bundle.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/plugins.bundle.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/base.light.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/menu.light.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/brand.dark.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/aside.light.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/fontawesome.all.min.css')}}">
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        <div class="error error-4 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url({{ asset('backend/img/error.jpg') }})">
            <div class="d-flex flex-column flex-row-fluid align-items-center justify-content-md-center text-center px-10 px-md-30 py-10 py-md-0 line-height-xs">
                <h1 class="error-title text-success font-weight-boldest line-height-sm">
                    @lang('backend.error.title')
                </h1>
                <p class="display-4 text-danger font-weight-boldest mt-md-0 line-height-md">
                    @lang('backend.error.desc')
                </p>
            </div>
        </div>
    </div>
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
    @js('backend/js/plugins.bundle.js')
    @js('backend/js/prismjs.bundle.js')
    @js('backend/js/scripts.bundle.js')
</body>
</html>
