<?php

namespace App\Http\Requests\Backend;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class FormPackageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->has('status') ? '1' : '0',
            'confirmed' => $this->has('confirmed') ? '1' : '0',
            'for_free' => $this->has('for_free') ? '1' : '0',
            'order' => $this->has('order') ? '1' : '0',
            'show_on_home' => $this->has('show_on_home') ? '1' : '0',
        ]);
    }

    public function rules()
    {
        $active_langs = Cache::rememberForever('active_langs', function () {
            return Language::active()->get();
        });

        foreach ($active_langs as $lang){
            $return[] = [
                'type:' . $lang['code'] => ['required'],
                'condition:' . $lang['code'] => ['required'],
                'description:' . $lang['code'] => ['required'],
            ];
        }

        // For Store
        $return[] = [
            'time' => ['nullable'],
            'price' => ['nullable'],
            'order' => ['nullable'],
            'status' => ['nullable'],
        ];

        return Arr::collapse($return);

    }

    public function attributes()
    {
        return [
            'image'     => trans('backend.labels.image'),
        ];
    }
}
