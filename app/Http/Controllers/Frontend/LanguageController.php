<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{

    public function changeLanguage($lang)
    {
        $locale = $lang;
        $langs = Cache::get('active_langs')->pluck('code')->toArray();
        if (in_array($locale, $langs)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            Cache::delete('categories');
            Cache::delete('video_news');
            Cache::delete('fresh_news');
            Cache::delete('top_10_news');
            Cache::delete('main_news');
        }
        return redirect()->back();
    }
}
