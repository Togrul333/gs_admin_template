<?php

namespace App\Providers;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;


class ShareServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $active_langs = Cache::rememberForever('active_langs', function () {
            return Language::active()->get();
        });
        $settings = Cache::rememberForever('settings', function () {
            return  Setting::get();
        });
        View::share([
            'langs' => $active_langs,
            'settings' => $settings,
        ]);

    }

    public function register()
    {}
}
