<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'about_store'   => 'required|string',
            'phone'         => 'required|string|max:20',
            'link_website'  => 'nullable|url|max:255',
            'services'      => 'required|string',
            'media'             => 'required|image|max:1024000',

            'location'      => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:stores,email',
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
