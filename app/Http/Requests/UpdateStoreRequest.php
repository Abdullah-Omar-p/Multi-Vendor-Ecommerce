<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'nullable|string|max:255',
            'about_store'  => 'nullable|string',
            'phone'        => 'nullable|string|max:20',
            'link_website' => 'nullable|url|max:255',
            'services'     => 'nullable|string',
            'location'     => 'nullable|string|max:255',
            'email'        => 'nullable|email|max:255|unique:stores,email',
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
