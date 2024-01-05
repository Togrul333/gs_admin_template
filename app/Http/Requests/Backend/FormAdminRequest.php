<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class FormAdminRequest extends FormRequest
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
        // For Store
        $return[] = [

            'name'     => ['required','max:30','regex:/^([^0-9]*)$/'],
            'email'        => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'min:8'],
            'role_id'  => ['required','exists:roles,id']
        ];

        // For Update
        if ($this->filled('_method') && $this->get('_method') == 'PUT') {
            $return[] = [
                'email'    => ['required','email','max:40',Rule::unique('admins')->ignore( $this->admin->id )],
                'password' => ['nullable', 'min:8'],
            ];
        }

        return Arr::collapse($return);
    }


}
