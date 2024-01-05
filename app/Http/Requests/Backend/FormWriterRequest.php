<?php

namespace App\Http\Requests\Backend;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class FormWriterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
//            'status' => $this->has('status') ? '1' : '0',
        ]);
    }

    public function rules()
    {
        // For Store
        $return[] = [
            'name' => 'required',
            'role' => 'required',
            'image' => 'nullable',
        ];

        return Arr::collapse($return);

    }

    public function attributes()
    {
        return [
        ];
    }
}
