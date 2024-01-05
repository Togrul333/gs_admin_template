<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        return [
            'email'        => 'required|email|max:40|unique:users,email,' . auth()->id(),
            'full_name'     => 'required',
            'image'     => 'required',
            'number'     => 'required',
            'password'     =>  ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
