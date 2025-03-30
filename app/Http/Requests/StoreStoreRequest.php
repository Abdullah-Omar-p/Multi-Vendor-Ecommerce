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
            'name' => 'required|string|max:255',
            'about_store' => 'required|string',
            'phone' => 'required|string|max:20',
            'link_website' => 'nullable|url|max:255',
            'services' => 'nullable|string',
            'location' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:stores,email',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
