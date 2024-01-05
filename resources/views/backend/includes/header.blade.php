<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <li class="menu-item menu-item-here menu-item-rel" aria-haspopup="true">
{{--                        <a href="{{ route('frontend.home') }}" class="menu-link btn-dark" target="_blank">--}}
{{--                            <span class="menu-text text-light">@lang('backend.buttons.website')</span>--}}
{{--                        </a>--}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="topbar">
            <div class="dropdown">
                <div class="topbar-item" data-offset="10px,0px">
                    <a href="javascript:void(0);" class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1" onclick="event.preventDefault(); document.getElementById('lang').submit();">
                        <img src="{{  app()->getLocale() == 'az' ? asset('backend/svg/en.svg') : asset('backend/svg/az.svg') }}" class="h-20px w-20px rounded-sm">
                    </a>
                    <form action="{{ route('backend.lang') }}" method="POST" id="lang">
                        @csrf
                        @method('PATCH')
                    </form>
                </div>
            </div>
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">
                        {{ admin()->name }}
                    </span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-danger">
                        <span class="symbol-label font-size-h5 font-weight-bold ">{{ short_name() }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
