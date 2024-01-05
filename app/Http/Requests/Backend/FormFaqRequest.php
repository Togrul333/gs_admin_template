<?php

namespace App\Http\Requests\Backend;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class FormFaqRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->has('status') ? '1' : '0',
        ]);
    }

    public function rules()
    {
        $active_langs = Cache::rememberForever('active_langs', function () {
            return Language::active()->get();
        });

        foreach ($active_langs as $lang){
            $return[] = [
                'question:' . $lang['code'] => ['required'],
                'answer:' . $lang['code'] => ['required'],
            ];
        }

        // For Store
        $return[] = [
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
