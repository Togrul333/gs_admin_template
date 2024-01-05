<?php

namespace App\Http\Requests\Backend;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class FormCategoryRequest extends FormRequest
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
        $return[] = [
            'image' => 'required',
            'status' => ['nullable'],
            'slug' => ['required'],
            'parent_id' => ['nullable'],
        ];
        $active_langs = Cache::rememberForever('active_langs', function () {
            return Language::active()->get();
        });
        foreach ($active_langs as $lang){
            $return[] = [
                'name:' . $lang['code'] => ['required'],
                'description:' . $lang['code'] => ['required'],
                'meta_title:' . $lang['code'] => ['required'],
                'meta_description:' . $lang['code'] => ['required'],
                'meta_keywords:' . $lang['code'] => ['required'],
                'title_first:' . $lang['code'] => ['nullable'],
                'title_second:' . $lang['code'] => ['nullable'],
            ];
        }

        // For Update
        if ($this->filled('_method') && $this->get('_method') == 'PUT') {
            $return[] = [
                'image' => 'filled',
            ];
        }

        return Arr::collapse($return);

    }

    public function attributes()
    {
        return [
            'image'     => trans('backend.labels.image'),
        ];
    }
}
