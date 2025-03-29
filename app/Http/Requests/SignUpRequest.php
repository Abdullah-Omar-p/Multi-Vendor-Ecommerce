<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token'    =>'required|integer|digits:6',
            'f_name'   => 'required|string|max:50',
            'l_name'   => 'required|string|max:50',
            'gender'   => 'required|string|in:male,female' ,
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string',
            'password' => 'required|confirmed'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            \App\Helpers\Helper::responseData(
                'Validation failed',
                false,
                $validator->errors(),
                422
            )
        );
    }
}
