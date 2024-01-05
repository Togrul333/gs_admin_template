<?php

namespace App\Http\Requests\Backend;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class FormWritingRequest extends FormRequest
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
        ]);

    }

    public function rules()
    {

        $active_langs = Cache::rememberForever('active_langs', function () {
            return Language::active()->get();
        });

        foreach ($active_langs as $lang) {
                $return[] = [
                    'title:' . $lang['code'] => ['nullable'],
                    'sub_title:' . $lang['code'] => ['nullable'],
                    'description:' . $lang['code'] => ['nullable'],
                    'slug:' . $lang['code'] => ['nullable'],
                ];
        }

        // For Store
        $return[] = [
            'image' => 'nullable',
            'alt_selected' => 'nullable',
            'alt' => 'nullable',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => ['nullable'],
            'confirmed' => ['nullable'],
            'status' => ['nullable'],
            'for_free' => ['nullable'],
            'type' => ['nullable'],
            'category_ids' => ['nullable'],
            'option_ids' => ['nullable'],
            'writer_id' => ['required'],
            'show_on_home' => ['nullable'],
            'action_date' => ['required'],
            'action_date_time' => ['required'],
            'video' => ['nullable'],
            'video_url' => ['nullable'],
            'selectMain' => ['nullable'],
            'selectMain_uploaded' => ['nullable'],
            'alt_uploaded' => ['nullable'],
        ];

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
            'image' => trans('backend.labels.image'),
        ];
    }
}
