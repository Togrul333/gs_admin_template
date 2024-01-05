<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class FormRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // For Store

        $return[] = [
            'name'        => ['required','max:20','regex:/^([^0-9]*)$/','unique:roles,name'],
            'permissions' => ['required','array','exists:permissions,id']
        ];

        // For Update
        if ($this->filled('_method') && $this->get('_method') == 'PUT') {
            $return[] = [
                'name' => ['required','max:20','regex:/^([^0-9]*)$/', Rule::unique('roles')->ignore( $this->role->id )],
            ];
        }

        return Arr::collapse($return);

    }

}
