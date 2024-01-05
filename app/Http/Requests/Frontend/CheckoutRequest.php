<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $return [] = [
            'package_id' => 'required|exists:packages,id',
        ];

        return Arr::collapse($return);

    }

}
