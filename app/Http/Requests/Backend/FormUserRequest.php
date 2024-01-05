<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class FormUserRequest extends FormRequest
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

            'first_name'     => ['required','max:30','regex:/^([^0-9]*)$/'],
            'last_name'     => ['required','max:30','regex:/^([^0-9]*)$/'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required','numeric','digits_between:1,20'],
            'password'     => ['required','min:8'],
            'address'      => ['required'],
            'birthdate' => ['required','date'],
            'status' => ['required'],
        ];

        // For Update
        if ($this->filled('_method') && $this->get('_method') == 'PUT') {
            $return[] = [
                'email'    => ['required','email','max:40',Rule::unique('users')->ignore( $this->user )],
                'password' => ['nullable', 'min:8'],
            ];
        }

        return Arr::collapse($return);

    }

}
