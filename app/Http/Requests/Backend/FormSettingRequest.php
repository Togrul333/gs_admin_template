<?php

namespace App\Http\Requests\Backend;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use function Symfony\Component\Translation\t;

class FormSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $active_langs = Cache::rememberForever('active_langs', function () {
            return Language::active()->get();
        });
        foreach ($active_langs as $lang){
            $return[] = [
                'content:' . $lang['code'] => ['required'],
            ];
        }

        // For Store
        $return[] = [
            'slug'=>['required'],
            'name'=>['required'],
        ];

        return Arr::collapse($return);

    }

    public function attributes()
    {
        return [

            'name'      => trans('backend.labels.name'),
            'content'   => trans('backend.labels.content'),
        ];
    }
}
