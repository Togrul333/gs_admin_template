<?php

use App\Models\Language;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;


if (!function_exists('locale')) {
    function locale()
    {
        return app()->getlocale();
    }
}

if (!function_exists('short_name')) {
    function short_name()
    {
        $array = explode(' ', admin()->name);

        if (count($array) < 2) {
            return strtoupper(substr($array[0], 0, 1));
        }

        return strtoupper(substr($array[0], 0, 1)) . strtoupper(substr($array[1], 0, 1));
    }
}
if (!function_exists('settings')) {
    function settings($type = null)
    {
        $return = '';

        $settings = Cache::remember('settings', 1800, function () {
            return collect(Setting::with('translations')->get());
        });

        foreach ($settings as $setting) {
            if ($setting->name == $type) {
                return $setting->translations->where('locale', locale())->first()->content ?? '';
            }
        }

        return $return;
    }
}


if (!function_exists('admin')) {
    function admin()
    {
        return auth('admin')->user();
    }
}

if (!function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}


if (!function_exists('notify')) {
    function notify($type, $message)
    {
        return "Swal.fire(
                {
                    icon:  '$type',
                    title: '$message',
                    showConfirmButton: false,
                    timer: 3000
                });";
    }
}

if (!function_exists('confirm')) {
    function confirm()
    {
        return "Swal.fire(
                {
                    title: '" . trans('backend.mixins.are_you_sure') . "',
                    text:  '" . trans('backend.mixins.wont_revert') . "',
                    icon:  'warning',
                    showCancelButton:   true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor:  '#d33',
                    confirmButtonText:  '" . trans('backend.buttons.delete') . "',
                    cancelButtonText:   '" . trans('backend.buttons.cancel') . "'
                })";
    }
}

if (!function_exists('confirm_update')) {
    function confirm_update()
    {
        return "Swal.fire(
                {
                    title: '" . trans('backend.mixins.are_you_sure') . "',
                    text:  '" . trans('backend.mixins.wont_update') . "',
                    icon:  'warning',
                    showCancelButton:   true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor:  '#d33',
                    confirmButtonText:  '" . trans('backend.buttons.update') . "',
                    cancelButtonText:   '" . trans('backend.buttons.update') . "'
                })";
    }
}


if (!function_exists('ipfind')) {
    function ipfind()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }
}

if (!function_exists('badge')) {
    function badge($value)
    {
        if ($value) {
            return '<span class="label label-lg label-inline label-light-success">' . trans('backend.mixins.active') . '</span>';
        }

        return '<span class="label label-lg label-inline label-light-danger">' . trans('backend.mixins.passive') . '</span>';
    }
}

if (!function_exists('image_url')) {
    function image_url($name)
    {
        return asset("uploads/$name");
    }
}

if (!function_exists('lang_url')) {
    function lang_url($locale)
    {
        $url = request()->segments();
        array_shift($url);
        $segments = implode('/', $url);

        return url("$locale/$segments");
    }
}

if (!function_exists('current_lang')) {
    function current_lang()
    {
        $result = '';

        foreach (active_langs() as $lang) {
            if (locale() == $lang->code) {
                $result = $lang->name;
                break;
            }
        }

        return $result;
    }
}

if (!function_exists('active_langs')) {
    function active_langs()
    {
        return Language::active()->get();
    }
}

if (!function_exists('default_lang')) {
    function default_lang()
    {
        return optional(Language::default()->first())->code ?? config('app.locale');
    }
}
if (!function_exists('settings')) {
    function settings($type = null)
    {
        $return = '';

        $settings = Cache::remember('settings', 1800, function () {
            return collect(Setting::with('translations')->get());
        });

        foreach ($settings as $setting) {
            if ($setting->name == $type) {
                return $setting->translations->where('locale', locale())->first()->content ?? '';
            }
        }

        return $return;
    }
}

if (!function_exists('translation')) {
    function translation($model)
    {
        return $model?->translations->where('locale', locale())->first();
    }
}

if (!function_exists('translation_first')) {
    function translation_first($model)
    {
        $translations = $model?->translations;
        return $translations
            ? $translations->where('locale', locale())->first() ?? $translations->first()
            : null;
    }
}
