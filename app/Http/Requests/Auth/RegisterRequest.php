<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
//        $this->dd();
        return [
            'email'        => 'required|email|max:40|unique:users,email',
            'full_name'     => 'required',
            'number'     => 'required',
            'package_id'     => 'nullable',
            'password'     =>  ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
    public function attributes()
    {
        return [

            'full_name'     => trans('frontend.labels.fullname'),
            'email'        => trans('frontend.labels.email'),
            'number' => trans('frontend.labels.phone_number'),
            'password'     => trans('frontend.labels.password'),
            'package_id'     => trans('frontend.labels.password'),
        ];
    }
}
