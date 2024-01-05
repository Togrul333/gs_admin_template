<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FormPermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'name' => Str::lower($this->name),
            'guard_name' => Str::lower($this->guard_name),
        ]);
    }

    public function rules()
    {
        // For Store
        $return[] =  [
            'name' => ['required','max:100','unique:permissions,name'],
            'guard_name' => ['required','max:100'],
        ];

        // For Update
        if ($this->filled('_method') && $this->get('_method') == 'PUT') {
            $return[] = [
                'name' => ['required','max:100',Rule::unique('permissions')->ignore($this->permission->id)],
                'guard_name' => ['required','max:100'],
            ];
        }

        return Arr::collapse($return);
    }


    public function attributes()
    {
        return [
            'name'     => trans('backend.labels.name'),
            'guard_name'     => trans('backend.labels.guard_name'),
        ];
    }
}
